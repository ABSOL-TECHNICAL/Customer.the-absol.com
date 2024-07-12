<?php

namespace App\Filament\Columns;

use Filament\Tables\Columns\Column;

class FileDownloadColumn extends Column
{
    public function __construct($label = null)
    {
        parent::__construct($label);
        
        // Set the view file for rendering this column
        $this->view('filament-tables::columns.file-download');
    }
}