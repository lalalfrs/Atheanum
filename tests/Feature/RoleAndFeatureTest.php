<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAndFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_newly_registered_user_defaults_to_member_role(): void
    {
        $response = $this->post('/register', [
            'name' => 'Budi Mahasiswa',
            'email' => 'budi.mahasiswa@athenaeum.test',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('dashboard'));

        $user = User::where('email', 'budi.mahasiswa@athenaeum.test')->first();
        $this->assertNotNull($user);
        $this->assertEquals('member', $user->role);
        $this->assertTrue($user->isMember());
        $this->assertFalse($user->isLibrarian());
        $this->assertFalse($user->isSuperAdmin());
    }

    public function test_designated_librarian_emails_are_superadmin(): void
    {
        $superAdmin1 = User::where('email', 'librarian@athenaeum.test')->first();
        $this->assertNotNull($superAdmin1);
        $this->assertTrue($superAdmin1->isSuperAdmin());
        $this->assertTrue($superAdmin1->isLibrarian());

        $superAdmin2 = User::where('email', 'librarian@atheanum.test')->first();
        $this->assertNotNull($superAdmin2);
        $this->assertTrue($superAdmin2->isSuperAdmin());
        $this->assertTrue($superAdmin2->isLibrarian());
    }

    public function test_superadmin_can_view_user_management_and_promote_user(): void
    {
        $superAdmin = User::where('email', 'librarian@athenaeum.test')->first();
        $member = User::where('role', 'member')->first();

        // Superadmin mengakses User Management
        $response = $this->actingAs($superAdmin)->get('/users');
        $response->assertStatus(200);
        $response->assertSee('Manajemen Pengguna &amp; Promosi Peran', false);

        // Superadmin mempromosikan member menjadi librarian
        $promoteResponse = $this->actingAs($superAdmin)->patch("/users/{$member->id}/role", [
            'role' => 'librarian',
        ]);

        $promoteResponse->assertRedirect();
        $this->assertEquals('librarian', $member->fresh()->role);
        $this->assertTrue($member->fresh()->isLibrarian());
    }

    public function test_non_superadmin_forbidden_from_user_management(): void
    {
        $member = User::where('role', 'member')->first();

        // Regular member coba akses /users
        $response = $this->actingAs($member)->get('/users');
        $response->assertStatus(403);

        // Regular member coba update role
        $patchResponse = $this->actingAs($member)->patch("/users/{$member->id}/role", [
            'role' => 'superadmin',
        ]);
        $patchResponse->assertStatus(403);
    }

    public function test_member_can_borrow_book_and_decrement_stock(): void
    {
        $member = User::where('role', 'member')->first();
        $book = Book::where('stock', '>', 1)->first();
        $initialStock = $book->stock;

        $response = $this->actingAs($member)->post('/loans', [
            'book_id' => $book->id,
            'notes' => 'Keperluan skripsi literatur',
        ]);

        $response->assertRedirect(route('loans.index'));

        // Stok buku berkurang 1
        $this->assertEquals($initialStock - 1, $book->fresh()->stock);

        // Rekaman peminjaman dibuat
        $this->assertDatabaseHas('loans', [
            'user_id' => $member->id,
            'book_id' => $book->id,
            'status' => 'dipinjam',
        ]);
    }

    public function test_member_cannot_borrow_out_of_stock_book(): void
    {
        $member = User::where('role', 'member')->first();
        $book = Book::first();
        $book->update(['stock' => 0]);

        $response = $this->actingAs($member)->post('/loans', [
            'book_id' => $book->id,
        ]);

        $response->assertSessionHas('error');
        $this->assertDatabaseMissing('loans', [
            'user_id' => $member->id,
            'book_id' => $book->id,
        ]);
    }

    public function test_member_cannot_exceed_maximum_active_loans_limit(): void
    {
        $member = User::where('role', 'member')->first();
        $books = Book::where('stock', '>', 2)->take(4)->get();

        // Buat 3 peminjaman aktif terlebih dahulu
        for ($i = 0; $i < 3; $i++) {
            Loan::create([
                'user_id' => $member->id,
                'book_id' => $books[$i]->id,
                'borrowed_at' => now()->toDateString(),
                'due_date' => now()->addDays(7)->toDateString(),
                'status' => 'dipinjam',
            ]);
        }

        // Pinjaman ke-4 harus ditolak
        $response = $this->actingAs($member)->post('/loans', [
            'book_id' => $books[3]->id,
        ]);

        $response->assertSessionHas('error');
    }

    public function test_member_can_return_borrowed_book_and_restore_stock(): void
    {
        $member = User::where('role', 'member')->first();
        $book = Book::first();
        $initialStock = $book->stock;

        $loan = Loan::create([
            'user_id' => $member->id,
            'book_id' => $book->id,
            'borrowed_at' => now()->toDateString(),
            'due_date' => now()->addDays(7)->toDateString(),
            'status' => 'dipinjam',
        ]);

        $response = $this->actingAs($member)->post("/loans/{$loan->id}/return");
        $response->assertRedirect();

        // Status berubah menjadi dikembalikan
        $this->assertEquals('dikembalikan', $loan->fresh()->status);
        $this->assertNotNull($loan->fresh()->returned_at);

        // Stok buku bertambah kembali
        $this->assertEquals($initialStock + 1, $book->fresh()->stock);
    }

    public function test_member_is_forbidden_from_managing_books_catalog(): void
    {
        $member = User::where('role', 'member')->first();
        $book = Book::first();

        // Member dilarang buka form tambah buku
        $this->actingAs($member)->get('/books/create')->assertStatus(403);

        // Member dilarang menyimpan buku baru
        $this->actingAs($member)->post('/books', [
            'title' => 'Buku Ilegal',
        ])->assertStatus(403);

        // Member dilarang edit buku
        $this->actingAs($member)->get("/books/{$book->id}/edit")->assertStatus(403);

        // Member dilarang update buku
        $this->actingAs($member)->put("/books/{$book->id}", [
            'title' => 'Buku Diubah',
        ])->assertStatus(403);

        // Member dilarang hapus buku
        $this->actingAs($member)->delete("/books/{$book->id}")->assertStatus(403);

        // Member dilarang ubah stok manual
        $this->actingAs($member)->post("/books/{$book->id}/stock", [
            'delta' => 1,
        ])->assertStatus(403);
    }

    public function test_anyone_can_view_ebook_catalog_and_interactive_reader(): void
    {
        $ebook = Book::where('is_ebook', true)->first();

        // Akses katalog e-book
        $catalogResponse = $this->get('/ebooks');
        $catalogResponse->assertStatus(200);
        $catalogResponse->assertSee('Koleksi E-Book &amp; Naskah Digital', false);

        // Akses canvas interaktif pembaca e-book
        $readerResponse = $this->get("/ebooks/{$ebook->id}");
        $readerResponse->assertStatus(200);
        $readerResponse->assertSee($ebook->title);
        $readerResponse->assertSee('Akses Baca Mandiri Anggota');
    }
}
