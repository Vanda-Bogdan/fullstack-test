<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'darth@mail.ru',
                'text' => 'Text',
                'date' => '2026-06-01 10:15:01',
            ],
            [
                'name' => 'aboba@gmail.com',
                'text' => 'Text comment2!',
                'date' => '2026-01-01 13:17:21',
            ],
            [
                'name' => 'mail_mail@mail.ru',
                'text' => 'New text.',
                'date' => '2026-09-03 20:09:45',
            ],

        ];

        $this->db->table('comments')->insertBatch($data);
    }
}
