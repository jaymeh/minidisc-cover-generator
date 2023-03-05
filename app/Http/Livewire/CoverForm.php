<?php

namespace App\Http\Livewire;

use League\Csv\Reader;
use Livewire\Component;
use League\Csv\Statement;
use Livewire\WithFileUploads;
use Intervention\Image\Facades\Image;
use BrianMcdo\ImagePalette\ImagePalette;

class CoverForm extends Component
{
    use WithFileUploads;

    public $file;
    public $title;
    public $year;
    public $tracks;
    public $image = false;
    public $albumImage;
    private $trackNames;

    public function updatedFile($file)
    {
        $csv = Reader::createFromPath($file->getRealPath(), 'r');
        $csv->setHeaderOffset(0);

        $titleRow = $csv->fetchOne(0);
        $this->title = $titleRow['NAME'];

        $records = Statement::create(null, 1)->process($csv);

        $trackNames = [];
        $key = 1;
        foreach ($records as $row) {
            $trackNames[] = $key . '. ' . $row['NAME'];
            $key++;
        }

        $this->tracks = implode("\n", $trackNames);
    }

    public function submitForm()
    {
        // Grab all the values.

        $img = Image::canvas(996, 927, '#121212')->insert(public_path('assets/images/template.png'));

        $img->text($this->title, 103, 110, function($font) {
            $this->spineFont($font);
        });

        $img->text($this->year, 892, 110, function($font) {
            $this->spineFont($font);
            $font->align('right');
        });


        $img->text($this->title, 103, 170, function($font) {
            $this->spineFont($font);
            $font->size(32);
        });

        $img->line(103, 200, 892, 200, function ($draw) {
            $draw->color('#ffffff');
        });

        $img->text($this->tracks, 103, 220, function($font) {
            $this->spineFont($font);
        });

        $path = '/assets/exports/' . uniqid() . '.jpg';

        $imagePath = public_path($path);
        $img->save($imagePath);

        $this->image = $path;

        // Save image

        // Attach path.

        // Render image.

        // return response()->streamDownload(function() use ($img) {
        //    echo $img->encode('png');
        // }, 'download', ['Content-Type' => 'image/png']);
    }

    public function render()
    {
        return view('livewire.cover-form', ['image' => $this->image]);
    }

    public function spineFont(&$font)
    {
        $font->file(public_path('assets/fonts/Inconsolata.ttf'));
        $font->size(24);
        $font->color('#ffffff');
        $font->align('left');
        $font->valign('top');
    }
}
