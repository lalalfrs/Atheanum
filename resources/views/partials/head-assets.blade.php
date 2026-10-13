<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    cream: '#F5F0E8',
                    'cream-dark': '#EDE7DB',
                    'cream-light': '#FAF7F2',
                    forest: '#1B3A2D',
                    'forest-light': '#2A5440',
                    coral: '#E8734A',
                    'coral-light': '#F4A27A',
                    accent: '#2373F4',
                    'accent-dark': '#1A5EC4',
                    'surface-grey': '#F0EEEB',
                    'text-primary': '#1A1A1A',
                    'text-secondary': '#6B6B6B',
                    'text-muted': '#9B9B9B',
                    'border-light': '#E8E5E0',
                },
                fontFamily: {
                    sans: ['DM Sans', 'system-ui', 'sans-serif'],
                    headline: ['DM Sans', 'system-ui', 'sans-serif'],
                },
                borderRadius: {
                    '2xl': '16px',
                    '3xl': '24px',
                },
            },
        },
    }
</script>

<style>
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        vertical-align: middle;
    }
    :focus-visible {
        outline: 2px solid #2373F4;
        outline-offset: 2px;
    }
    ::-webkit-scrollbar { width: 5px; height: 5px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: #d4d0ca; border-radius: 9999px; }
    ::-webkit-scrollbar-thumb:hover { background: #b0aba3; }
</style>
