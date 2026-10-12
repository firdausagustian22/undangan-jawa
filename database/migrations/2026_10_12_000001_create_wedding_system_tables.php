<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Weddings Table (Core Configuration)
        Schema::create('weddings', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique()->default('arya-sekar');
            $table->string('title')->default('Pernikahan Raden Mas Arya & Raden Ajeng Sekar');
            $table->string('couple_short_names')->default('Arya & Sekar');
            $table->dateTime('wedding_date')->default('2026-11-28 08:00:00');
            $table->text('quote_arabic')->nullable();
            $table->text('quote_translation')->nullable();
            $table->string('quote_source')->default('QS. Ar-Rum: 21');
            $table->text('javanese_quote')->nullable();
            $table->text('introduction_text')->nullable();
            $table->text('closing_text')->nullable();
            $table->string('music_url')->default('/assets/audio/gamelan-modern.mp3');
            $table->string('music_title')->default('Ladrang Wilujeng & Romantic Gamelan Instrumental');
            $table->boolean('is_music_enabled')->default(true);
            $table->boolean('is_rsvp_enabled')->default(true);
            $table->boolean('is_wishes_enabled')->default(true);
            $table->boolean('is_gift_enabled')->default(true);
            $table->boolean('require_wishes_approval')->default(true);
            $table->timestamps();
        });

        // 2. Couple Profiles (Groom & Bride)
        Schema::create('couple_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wedding_id')->constrained('weddings')->cascadeOnDelete();
            $table->enum('role', ['groom', 'bride']);
            $table->string('full_name');
            $table->string('nickname');
            $table->string('title_javanese')->nullable(); // e.g. Raden Mas / Raden Ajeng
            $table->string('father_name');
            $table->string('mother_name');
            $table->string('child_order'); // e.g. "Putra pertama dari dua bersaudara"
            $table->string('photo_path')->nullable();
            $table->text('bio')->nullable();
            $table->string('instagram_username')->nullable();
            $table->string('instagram_url')->nullable();
            $table->timestamps();
        });

        // 3. Events (Akad Nikah, Resepsi, Midodareni, etc.)
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wedding_id')->constrained('weddings')->cascadeOnDelete();
            $table->string('title'); // Akad Nikah / Resepsi Pernikahan / Midodareni
            $table->string('category')->default('utama'); // akad, resepsi, adat
            $table->date('event_date');
            $table->string('start_time', 10);
            $table->string('end_time', 15)->default('Selesai');
            $table->string('time_zone', 10)->default('WIB');
            $table->string('venue_name');
            $table->text('address');
            $table->string('maps_url')->nullable();
            $table->text('maps_embed')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_countdown_target')->default(false);
            $table->integer('order_num')->default(0);
            $table->timestamps();
        });

        // 4. Guests Table (Invited Guests)
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wedding_id')->constrained('weddings')->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->index();
            $table->string('invitation_code', 20)->unique();
            $table->string('token', 64)->unique();
            $table->string('group_name', 50)->default('Umum'); // VIP, Keluarga, Sahabat, Teman Kantor
            $table->string('phone', 30)->nullable();
            $table->integer('quota')->default(2);
            $table->boolean('is_sent')->default(false);
            $table->dateTime('sent_at')->nullable();
            $table->integer('views_count')->default(0);
            $table->dateTime('last_viewed_at')->nullable();
            $table->timestamps();
        });

        // 5. RSVPs Table (Responses)
        Schema::create('rsvps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wedding_id')->constrained('weddings')->cascadeOnDelete();
            $table->foreignId('guest_id')->nullable()->constrained('guests')->nullOnDelete();
            $table->string('guest_name');
            $table->enum('status', ['hadir', 'tidak_hadir', 'ragu'])->default('hadir');
            $table->integer('attendee_count')->default(1);
            $table->string('phone', 30)->nullable();
            $table->text('notes')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });

        // 6. Attendance Check-ins (Hari-H Kedatangan Riil)
        Schema::create('attendance_checkins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wedding_id')->constrained('weddings')->cascadeOnDelete();
            $table->foreignId('guest_id')->constrained('guests')->cascadeOnDelete();
            $table->foreignId('checked_in_by')->nullable()->constrained('users')->nullOnDelete();
            $table->integer('actual_attendees')->default(1);
            $table->dateTime('checkin_time');
            $table->enum('method', ['qr_scan', 'manual'])->default('qr_scan');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->unique('guest_id'); // Satu tamu satu record checkin utama
        });

        // 7. Wishes / Guestbook Table
        Schema::create('wishes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wedding_id')->constrained('weddings')->cascadeOnDelete();
            $table->foreignId('guest_id')->nullable()->constrained('guests')->nullOnDelete();
            $table->string('name');
            $table->text('message');
            $table->enum('attendance_status', ['hadir', 'tidak_hadir', 'ragu'])->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->dateTime('approved_at')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
        });

        // 8. Gallery Images
        Schema::create('gallery_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wedding_id')->constrained('weddings')->cascadeOnDelete();
            $table->string('title')->nullable();
            $table->string('image_path');
            $table->string('category', 50)->default('prewedding'); // prewedding, lamaran, akad
            $table->string('caption')->nullable();
            $table->integer('order_num')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 9. Love Story Timeline
        Schema::create('love_story_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wedding_id')->constrained('weddings')->cascadeOnDelete();
            $table->string('title');
            $table->string('story_date', 50); // e.g. "Oktober 2021" / "12 Mei 2024"
            $table->text('description');
            $table->string('image_path')->nullable();
            $table->integer('order_num')->default(0);
            $table->timestamps();
        });

        // 10. Gift Accounts (Amplop Digital & Kado Fisik)
        Schema::create('gift_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wedding_id')->constrained('weddings')->cascadeOnDelete();
            $table->string('bank_name'); // BCA, Mandiri, BRI, BSI, QRIS
            $table->string('account_number');
            $table->string('account_holder');
            $table->string('qr_code_image')->nullable();
            $table->text('gift_address')->nullable();
            $table->string('recipient_name')->nullable();
            $table->string('recipient_phone')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 11. Audit Logs (Log Aktivitas Admin)
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('action', 100);
            $table->text('description');
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('gift_accounts');
        Schema::dropIfExists('love_story_entries');
        Schema::dropIfExists('gallery_images');
        Schema::dropIfExists('wishes');
        Schema::dropIfExists('attendance_checkins');
        Schema::dropIfExists('rsvps');
        Schema::dropIfExists('guests');
        Schema::dropIfExists('events');
        Schema::dropIfExists('couple_profiles');
        Schema::dropIfExists('weddings');
    }
};
