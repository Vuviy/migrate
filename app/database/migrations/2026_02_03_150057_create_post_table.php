<?php

use App\DB\Migration;

return new class extends Migration {

    public function up(): void
    {
         $sql = $this->schema->create('posts', function ($table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->string('body');
        });

        $this->db->query($sql);
    }

    public function down(): void
    {
        $this->db->query('DROP TABLE posts');
    }
};