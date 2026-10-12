<?php

namespace Database\Seeders;

use App\Models\AuditLog;
use App\Models\CoupleProfile;
use App\Models\Event;
use App\Models\GalleryImage;
use App\Models\GiftAccount;
use App\Models\Guest;
use App\Models\LoveStoryEntry;
use App\Models\Rsvp;
use App\Models\User;
use App\Models\Wedding;
use App\Models\Wish;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@wedding.com'],
            [
                'name' => 'Kanjeng Panitiya Wedding',
                'password' => Hash::make('password123'),
            ]
        );

        // 2. Wedding Main Configuration
        $wedding = Wedding::firstOrCreate(
            ['slug' => 'arya-sekar'],
            [
                'title' => 'Pawiwahan Ageng Raden Mas Arya Daniswara & Raden Ajeng Sekar Kinanti',
                'couple_short_names' => 'Arya & Sekar',
                'wedding_date' => '2026-11-28 08:00:00',
                'quote_arabic' => 'وَمِنْ ءَايَٰتِهِۦٓ أَنْ خَلَقَ لَكُم مِّنْ أَنفُسِكُمْ أَزْوَٰجًا لِّتَسْكُنُوٓا۟ إِلَيْهَا وَجَعَلَ بَيْنَكُم مَّوَدَّةً وَرَحْمَةً ۚ إِنَّ فِى ذَٰلِكَ لَءَايَٰتٍ لِّقَوْمٍ يَتَفَكَّرُونَ',
                'quote_translation' => 'Dan di antara tanda-tanda (kebesaran)-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu cenderung dan merasa tenteram kepadanya, dan Dia menjadikan di antaramu rasa kasih dan sayang.',
                'quote_source' => 'QS. Ar-Rum: 21',
                'javanese_quote' => 'Memayu Hayuning Bawana, Manunggaling Cipta Rasa Karsa Menuju Bebrayan Agung Kang Rahayu lan Bagya Mulya.',
                'introduction_text' => 'Kanthi Asmaning Gusti Ingkang Maha Welas lan Maha Asih. Sinartan raos syukur lan hangaturaken panuwun, lumunturing sih wilasa mugi kasantosan tansah kajiwa kasarira dumateng panjenengan sedaya. Kanthi hangajab berkah lan pangestu, keparenga kulo sakulawarga ngaturi rawuh panjenengan ing adicara Pawiwahan Pernikahan putra-putri kito.',
                'closing_text' => 'Maturnuwun sanget awit saking sih kawigatosan, rawuh, saha donga pangestu panjenengan sedaya. Mugi Gusti Ingkang Maha Asih tansah paring berkah lan karaharjan dumateng kito sedaya.',
                'music_url' => '/assets/audio/gamelan-modern.mp3',
                'music_title' => 'Ladrang Wilujeng & Suara Gamelan Pengantin Jawa Keraton',
                'is_music_enabled' => true,
                'is_rsvp_enabled' => true,
                'is_wishes_enabled' => true,
                'is_gift_enabled' => true,
                'require_wishes_approval' => true,
            ]
        );

        // 3. Couple Profiles
        CoupleProfile::firstOrCreate(
            ['wedding_id' => $wedding->id, 'role' => 'groom'],
            [
                'full_name' => 'Raden Mas Arya Daniswara, S.T.',
                'nickname' => 'Arya',
                'title_javanese' => 'Mempelai Kakung',
                'father_name' => 'Bpk. K.R.T. Bambang Sutrisnohadiningrat',
                'mother_name' => 'Ibu Hj. Siti Rahayu Kusumaningrum',
                'child_order' => 'Putra Pertama dari Tiga Bersaudara',
                'photo_path' => '/assets/images/couple/groom.jpg',
                'bio' => 'Lulusan Teknik Arsitektur Universitas Gadjah Mada yang berdedikasi menjaga kelestarian seni arsitektur dan filosofi Jawa.',
                'instagram_username' => '@arya.daniswara',
                'instagram_url' => 'https://instagram.com',
            ]
        );

        CoupleProfile::firstOrCreate(
            ['wedding_id' => $wedding->id, 'role' => 'bride'],
            [
                'full_name' => 'Raden Ajeng Sekar Kinanti, S.Psi., M.Psi.',
                'nickname' => 'Sekar',
                'title_javanese' => 'Mempelai Putri',
                'father_name' => 'Bpk. Dr. H. Haryo Tejakusuma, M.Si.',
                'mother_name' => 'Ibu Dra. Hj. Endang Sri Lestari',
                'child_order' => 'Putri Kedua dari Tiga Bersaudara',
                'photo_path' => '/assets/images/couple/bride.jpg',
                'bio' => 'Psikolog muda yang mencintai seni tari klasik Keraton Yogyakarta serta pelestari busana kebaya Jawa klasik.',
                'instagram_username' => '@sekarkinanti',
                'instagram_url' => 'https://instagram.com',
            ]
        );

        // 4. Events
        Event::firstOrCreate(
            ['wedding_id' => $wedding->id, 'title' => 'Akad Nikah'],
            [
                'category' => 'akad',
                'event_date' => '2026-11-28',
                'start_time' => '08:00',
                'end_time' => '10:00',
                'time_zone' => 'WIB',
                'venue_name' => 'Kagungan Ndalem Pendopo Agung Ambarrukmo',
                'address' => 'Jl. Laksda Adisucipto No.81, Caturtunggal, Sleman, D.I. Yogyakarta',
                'maps_url' => 'https://maps.google.com/?q=Pendopo+Agung+Ambarrukmo+Yogyakarta',
                'maps_embed' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.0763261626296!2d110.3986872!3d-7.7817446!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a59c00b0e5b77%3A0xe543e8bb8baeb772!2sPendopo%20Agung%20Royal%20Ambarrukmo!5e0!3m2!1sid!2sid!4v1700000000000',
                'is_active' => true,
                'is_countdown_target' => true,
                'order_num' => 1,
            ]
        );

        Event::firstOrCreate(
            ['wedding_id' => $wedding->id, 'title' => 'Upacara Adat Panggih Gagrak Ngayogyakarta'],
            [
                'category' => 'adat',
                'event_date' => '2026-11-28',
                'start_time' => '10:30',
                'end_time' => '11:30',
                'time_zone' => 'WIB',
                'venue_name' => 'Balaikota Pendopo Sasana Hinggil Dwi Abad',
                'address' => 'Alun-alun Kidul, Kraton, Kota Yogyakarta, D.I. Yogyakarta',
                'maps_url' => 'https://maps.google.com/?q=Sasana+Hinggil+Dwi+Abad+Yogyakarta',
                'maps_embed' => null,
                'is_active' => true,
                'is_countdown_target' => false,
                'order_num' => 2,
            ]
        );

        Event::firstOrCreate(
            ['wedding_id' => $wedding->id, 'title' => 'Resepsi Pawiwahan Ageng'],
            [
                'category' => 'resepsi',
                'event_date' => '2026-11-28',
                'start_time' => '11:30',
                'end_time' => '14:30',
                'time_zone' => 'WIB',
                'venue_name' => 'Grand Ballroom Kagungan Ndalem Sasana Hinggil',
                'address' => 'Jl. Alun-Alun Selatan No.1, Patehan, Kraton, Kota Yogyakarta',
                'maps_url' => 'https://maps.google.com/?q=Alun-Alun+Selatan+Yogyakarta',
                'maps_embed' => null,
                'is_active' => true,
                'is_countdown_target' => false,
                'order_num' => 3,
            ]
        );

        // 5. Love Story Timeline
        $stories = [
            [
                'title' => 'Pitepangan Kapisan (Pertemuan Pertama)',
                'story_date' => '14 Mei 2021',
                'description' => 'Takdir mempertemukan kami di pelataran Candi Prambanan saat pementasan Sendratari Ramayana. Sebuah tatapan singkat berbalut senyuman hangat menjadi awal lembaran kisah asmara kami.',
                'image_path' => '/assets/images/gallery/story-1.jpg',
                'order_num' => 1,
            ],
            [
                'title' => 'Niti Wacana (Menjalin Komitmen)',
                'story_date' => '08 Agustus 2023',
                'description' => 'Dua tahun saling mengenal watak, mendengarkan asa, dan merajut impian bersama. Kami sepakat untuk menyatukan dua rasa dalam ikatan kesetiaan luhur.',
                'image_path' => '/assets/images/gallery/story-2.jpg',
                'order_num' => 2,
            ],
            [
                'title' => 'Adicara Lamaran (Keluarga Nyantri & Lamaran)',
                'story_date' => '20 Juni 2026',
                'description' => 'Keluarga besar Arya sowan pinanggih dhateng dalem kulawarga Sekar. Kanthi tulus ikhlas, pinangan katampi kanthi sukacita lan suka gembira sinartan donga pangestu.',
                'image_path' => '/assets/images/gallery/story-3.jpg',
                'order_num' => 3,
            ],
            [
                'title' => 'Dina Mulya Pawiwahan (Hari Pengantin)',
                'story_date' => '28 November 2026',
                'description' => 'Insya Allah, atas ridho Allah SWT dan restu kedua orang tua, kami melangkah mantap menuju mahligai rumah tangga yang sakinah, mawaddah, warahmah.',
                'image_path' => '/assets/images/gallery/story-4.jpg',
                'order_num' => 4,
            ],
        ];

        foreach ($stories as $story) {
            LoveStoryEntry::firstOrCreate(
                ['wedding_id' => $wedding->id, 'title' => $story['title']],
                $story
            );
        }

        // 6. Gift Accounts
        $gifts = [
            [
                'bank_name' => 'Bank Central Asia (BCA)',
                'account_number' => '8691524310',
                'account_holder' => 'Raden Mas Arya Daniswara',
                'qr_code_image' => '/assets/images/ornaments/qris-bca.png',
                'gift_address' => 'Ndalan Ngadisuryan No. 24, Patehan, Kraton, Kota Yogyakarta 55133',
                'recipient_name' => 'Arya Daniswara & Sekar Kinanti',
                'recipient_phone' => '081234567890',
                'is_active' => true,
            ],
            [
                'bank_name' => 'Bank Mandiri',
                'account_number' => '1370018928374',
                'account_holder' => 'Raden Ajeng Sekar Kinanti',
                'qr_code_image' => null,
                'gift_address' => 'Ndalan Ngadisuryan No. 24, Patehan, Kraton, Kota Yogyakarta 55133',
                'recipient_name' => 'Sekar Kinanti',
                'recipient_phone' => '081298765432',
                'is_active' => true,
            ],
        ];

        foreach ($gifts as $gift) {
            GiftAccount::firstOrCreate(
                ['wedding_id' => $wedding->id, 'account_number' => $gift['account_number']],
                $gift
            );
        }

        // 7. Gallery Images
        $gallery = [
            [
                'title' => 'Busana Kasunanan Surakarta & Yogyakarta',
                'image_path' => '/assets/images/gallery/gallery-1.jpg',
                'category' => 'prewedding',
                'caption' => 'Keanggunan busana Pengantin Jawa Dodotan & Basahan.',
                'order_num' => 1,
            ],
            [
                'title' => 'Pelataran Pendopo Ageng',
                'image_path' => '/assets/images/gallery/gallery-2.jpg',
                'category' => 'prewedding',
                'caption' => 'Suasana syahdu di sudut arsitektur Rumah Joglo klasik.',
                'order_num' => 2,
            ],
            [
                'title' => 'Sorot Mata Penuh Kasih',
                'image_path' => '/assets/images/gallery/gallery-3.jpg',
                'category' => 'prewedding',
                'caption' => 'Kidung asmara ing madyaning kalbu.',
                'order_num' => 3,
            ],
            [
                'title' => 'Kain Batik Sidomukti Prada',
                'image_path' => '/assets/images/gallery/gallery-4.jpg',
                'category' => 'prewedding',
                'caption' => 'Batik Sidomukti lambang kemakmuran dan keluhuran budi.',
                'order_num' => 4,
            ],
            [
                'title' => 'Ronce Melati & Paes Ageng',
                'image_path' => '/assets/images/gallery/gallery-5.jpg',
                'category' => 'prewedding',
                'caption' => 'Harum semerbak kembang melati pengikat janji suci.',
                'order_num' => 5,
            ],
            [
                'title' => 'Menatap Masa Depan Gemilang',
                'image_path' => '/assets/images/gallery/gallery-6.jpg',
                'category' => 'prewedding',
                'caption' => 'Sareng-sareng ngajengaken gesang mulya.',
                'order_num' => 6,
            ],
        ];

        foreach ($gallery as $item) {
            GalleryImage::firstOrCreate(
                ['wedding_id' => $wedding->id, 'title' => $item['title']],
                $item
            );
        }

        // 8. Sample Guests (VIP, Keluarga, Sahabat, Rekan Kerja)
        $sampleGuests = [
            [
                'name' => 'Prof. Dr. Ir. Budi Rahardjo, M.Sc.',
                'group_name' => 'VIP',
                'invitation_code' => 'JW-VIP001',
                'token' => 'guest-token-vip-budirahardjo-2026',
                'phone' => '081234567801',
                'quota' => 2,
                'is_sent' => true,
                'views_count' => 3,
            ],
            [
                'name' => 'Bpk. H. Ananto Danang & Keluarga',
                'group_name' => 'Keluarga',
                'invitation_code' => 'JW-KEL001',
                'token' => 'guest-token-kel-anantodanang-2026',
                'phone' => '081234567802',
                'quota' => 4,
                'is_sent' => true,
                'views_count' => 5,
            ],
            [
                'name' => 'Dimas Wicaksono & Partner',
                'group_name' => 'Sahabat',
                'invitation_code' => 'JW-SHB001',
                'token' => 'guest-token-shb-dimaswicak-2026',
                'phone' => '081234567803',
                'quota' => 2,
                'is_sent' => true,
                'views_count' => 2,
            ],
            [
                'name' => 'Dewi Anggraini, S.T.',
                'group_name' => 'Teman Kantor',
                'invitation_code' => 'JW-KTR001',
                'token' => 'guest-token-ktr-dewianggraini-2026',
                'phone' => '081234567804',
                'quota' => 1,
                'is_sent' => false,
                'views_count' => 0,
            ],
            [
                'name' => 'K.R.H. Hendro Kusumo & Ibu',
                'group_name' => 'VIP',
                'invitation_code' => 'JW-VIP002',
                'token' => 'guest-token-vip-hendrokusumo-2026',
                'phone' => '081234567805',
                'quota' => 2,
                'is_sent' => true,
                'views_count' => 1,
            ],
        ];

        foreach ($sampleGuests as $gData) {
            $guest = Guest::firstOrCreate(
                ['wedding_id' => $wedding->id, 'invitation_code' => $gData['invitation_code']],
                array_merge($gData, ['slug' => Str::slug($gData['name'])])
            );

            // Create sample RSVP for some guests
            if ($gData['invitation_code'] === 'JW-VIP001') {
                Rsvp::firstOrCreate(
                    ['guest_id' => $guest->id],
                    [
                        'wedding_id' => $wedding->id,
                        'guest_name' => $guest->name,
                        'status' => 'hadir',
                        'attendee_count' => 2,
                        'phone' => $guest->phone,
                        'notes' => 'Insya Allah hadir berdua tepat waktu.',
                    ]
                );
            } elseif ($gData['invitation_code'] === 'JW-KEL001') {
                Rsvp::firstOrCreate(
                    ['guest_id' => $guest->id],
                    [
                        'wedding_id' => $wedding->id,
                        'guest_name' => $guest->name,
                        'status' => 'hadir',
                        'attendee_count' => 4,
                        'phone' => $guest->phone,
                        'notes' => 'Mugi tansah rahayu wilujeng, kulo sakeluwarga rawuh.',
                    ]
                );
            } elseif ($gData['invitation_code'] === 'JW-SHB001') {
                Rsvp::firstOrCreate(
                    ['guest_id' => $guest->id],
                    [
                        'wedding_id' => $wedding->id,
                        'guest_name' => $guest->name,
                        'status' => 'ragu',
                        'attendee_count' => 1,
                        'phone' => $guest->phone,
                        'notes' => 'Masih menyesuaikan jadwal dinas luar kota, semoga bisa hadir!',
                    ]
                );
            }
        }

        // 9. Sample Wishes (Approved & Pending)
        $wishes = [
            [
                'name' => 'Prof. Dr. Ir. Budi Rahardjo, M.Sc.',
                'message' => 'Ndherek mangayubagya Mas Arya lan Mbak Sekar. Mugi-mugi dados kulawarga ingkang sakinah, mawaddah, warahmah, tansah pinaringan berkah dalah kawilujengan dening Gusti Allah SWT.',
                'attendance_status' => 'hadir',
                'status' => 'approved',
                'approved_at' => now(),
            ],
            [
                'name' => 'Bpk. H. Ananto Danang',
                'message' => 'Sugeng ngancik ing gesang enggal, mugi tansah ayem tentrem, runtut atut runtut kados mimi lan mintuna. Berkah kagem panjenengan kekalih!',
                'attendance_status' => 'hadir',
                'status' => 'approved',
                'approved_at' => now(),
            ],
            [
                'name' => 'Larasati & Kelana',
                'message' => 'Selamat berbahagia sahabatku Sekar & Mas Arya! Sangat terharu melihat perjalanan cinta kalian. Semoga selalu saling melengkapi selamanya!',
                'attendance_status' => 'hadir',
                'status' => 'approved',
                'approved_at' => now(),
            ],
            [
                'name' => 'K.R.H. Hendro Kusumo',
                'message' => 'Ngaturaken puji syukur dhumateng Gusti Ingkang Murbeng Dumadi. Mugi palakrama punika dados margining karaharjan tumrap kulawarga ageng.',
                'attendance_status' => 'hadir',
                'status' => 'pending', // Menunggu moderasi
                'approved_at' => null,
            ],
        ];

        foreach ($wishes as $w) {
            Wish::firstOrCreate(
                ['wedding_id' => $wedding->id, 'name' => $w['name']],
                $w
            );
        }

        // 10. Initial Audit Log
        AuditLog::record('SYSTEM_INIT', 'Sistem inisialisasi basis data pernikahan adat Jawa berhasil dilakukan.', $admin->id);
    }
}
