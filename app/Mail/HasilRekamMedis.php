<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class HasilRekamMedis extends Mailable
{
    use Queueable, SerializesModels;

    public $siswa;
    public $rekamMedis;

    public function __construct($siswa, $rekamMedis)
    {
        $this->siswa = $siswa;
        $this->rekamMedis = $rekamMedis;
    }

    public function build()
    {
        return $this->subject('Hasil Rekam Medis - MediSchool')
                    ->view('emails.hasil_rekam_medis');
    }
}