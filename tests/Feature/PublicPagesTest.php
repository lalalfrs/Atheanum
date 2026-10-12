<?php

namespace Tests\Feature;

use App\Models\LibraryEvent;
use App\Models\News;
use App\Models\SiteVisit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_renders_and_records_site_visit(): void
    {
        // Kunjungan pertama
        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('Katalog / OPAC');
        $response->assertSee('CJS per Prodi');
        $response->assertSee('E-Book Digital');
        $response->assertSee('Statistik Kunjungan');

        $this->assertEquals(1, SiteVisit::count());

        // Kunjungan kedua (pengunjung & hari yang sama): tidak boleh melempar UniqueConstraintViolationException
        $responseSecond = $this->get(route('home'));
        $responseSecond->assertStatus(200);

        // Jumlah kunjungan tetap 1 unik per hari
        $this->assertEquals(1, SiteVisit::count());
    }

    public function test_reserved_slugs_do_not_collide_with_action_routes(): void
    {
        $news = News::factory()->create([
            'title' => 'Tulis',
        ]);

        $this->assertNotEquals('tulis', $news->slug);
        $this->assertEquals('tulis-1', $news->slug);

        $event = LibraryEvent::factory()->create([
            'title' => 'Tambah',
        ]);

        $this->assertNotEquals('tambah', $event->slug);
        $this->assertEquals('tambah-1', $event->slug);
    }

    public function test_about_page_renders_with_circulation_policies(): void
    {
        $response = $this->get(route('pages.about'));

        $response->assertStatus(200);
        $response->assertSee('Tentang');
        $response->assertSee('Kebijakan Sirkulasi');
        $response->assertSee('7 Hari');
        $response->assertSee('3 Buku');
    }

    public function test_contact_page_renders(): void
    {
        $response = $this->get(route('pages.contact'));

        $response->assertStatus(200);
        $response->assertSee('Kontak Pengelola Perpustakaan');
        $response->assertSee('Lokasi Fisik');
    }

    public function test_librarians_directory_renders(): void
    {
        $this->seed();

        $response = $this->get(route('pages.librarians'));

        $response->assertStatus(200);
        $response->assertSee('Direktori Pustakawan');
        $response->assertSee('librarian@athenaeum.test');
    }

    public function test_help_and_chatbot_page_renders(): void
    {
        $response = $this->get(route('pages.help'));

        $response->assertStatus(200);
        $response->assertSee('Chat Asisten');
        $response->assertSee('Asisten Virtual Athenaeum');
        $response->assertSee('Pertanyaan yang Sering Diajukan');
    }

    public function test_cjs_per_prodi_page_renders(): void
    {
        $response = $this->get(route('cjs.index'));

        $response->assertStatus(200);
        $response->assertSee('Pemilihan CJS per Program Studi');
        $response->assertSee('Teknik Informatika');
    }

    public function test_news_index_and_detail_renders(): void
    {
        $news = News::factory()->create([
            'title' => 'Pengumuman Ujian Semester',
            'excerpt' => 'Layanan perpustakaan buka hingga malam.',
            'body' => 'Isi berita pengumuman lengkap...',
        ]);

        $responseIndex = $this->get(route('news.index'));
        $responseIndex->assertStatus(200);
        $responseIndex->assertSee('Pengumuman Ujian Semester');

        $responseDetail = $this->get(route('news.show', $news));
        $responseDetail->assertStatus(200);
        $responseDetail->assertSee('Pengumuman Ujian Semester');
        $responseDetail->assertSee('Isi berita pengumuman lengkap...');
    }

    public function test_events_index_and_detail_renders(): void
    {
        $event = LibraryEvent::factory()->create([
            'title' => 'Workshop Sitasi Mendeley',
            'location' => 'Ruang Multimedia Lt. 2',
            'description' => 'Pelatihan manajemen sitasi akademik.',
        ]);

        $responseIndex = $this->get(route('events.index'));
        $responseIndex->assertStatus(200);
        $responseIndex->assertSee('Workshop Sitasi Mendeley');

        $responseDetail = $this->get(route('events.show', $event));
        $responseDetail->assertStatus(200);
        $responseDetail->assertSee('Workshop Sitasi Mendeley');
        $responseDetail->assertSee('Ruang Multimedia Lt. 2');
    }

    public function test_librarian_can_publish_news_and_event(): void
    {
        $librarian = User::factory()->create([
            'email' => 'librarian@athenaeum.test',
            'role' => 'librarian',
        ]);

        $newsResponse = $this->actingAs($librarian)->post(route('news.store'), [
            'title' => 'Koleksi Baru Buku AI',
            'excerpt' => 'Tersedia 20 judul baru.',
            'body' => 'Buku-buku baru telah ditambahkan ke rak.',
        ]);
        $newsResponse->assertSessionHasNoErrors();
        $this->assertDatabaseHas('news', ['title' => 'Koleksi Baru Buku AI']);

        $eventResponse = $this->actingAs($librarian)->post(route('events.store'), [
            'title' => 'Bedah Buku Fiksi Klasik',
            'description' => 'Diskusi novel klasik bersama narasumber.',
            'location' => 'Aula Utama',
            'starts_at' => now()->addDays(5)->toDateTimeString(),
        ]);
        $eventResponse->assertSessionHasNoErrors();
        $this->assertDatabaseHas('library_events', ['title' => 'Bedah Buku Fiksi Klasik']);
    }

    public function test_regular_member_cannot_create_news_or_event(): void
    {
        $member = User::factory()->create([
            'role' => 'member',
        ]);

        $this->actingAs($member)->get(route('news.create'))->assertForbidden();
        $this->actingAs($member)->get(route('events.create'))->assertForbidden();
    }
}
