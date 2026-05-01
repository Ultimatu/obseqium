<?php

namespace App\Filament\Resources\Testimonials\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class TestimonialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Témoignage')->description('Avis client avec note et mise en forme.')->columns(['default' => 1, 'sm' => 2])->schema([
                TextInput::make('author_name')->label('Nom')->prefixIcon(Heroicon::OutlinedUser)->required(),
                TextInput::make('author_role')->label('Fonction')->prefixIcon(Heroicon::OutlinedBriefcase),
                TextInput::make('author_company')->label('Société')->prefixIcon(Heroicon::OutlinedBuildingOffice),
                FileUpload::make('author_avatar')->label('Photo')->image()->disk('public')->directory('testimonials')->circular(),
                Textarea::make('content')->label('Témoignage')->required()->rows(4)->columnSpanFull(),
                Select::make('rating')->label('Note')->options([5 => '⭐⭐⭐⭐⭐', 4 => '⭐⭐⭐⭐', 3 => '⭐⭐⭐'])->default(5),
                TextInput::make('order')->label('Ordre')->numeric()->default(0),
                Toggle::make('is_featured')->label('Mis en avant')->inline(false),
                Toggle::make('is_active')->label('Visible')->default(true)->inline(false),
            ]),
        ]);
    }
}