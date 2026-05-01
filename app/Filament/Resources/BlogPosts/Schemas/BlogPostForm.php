<?php

namespace App\Filament\Resources\BlogPosts\Schemas;

use App\Models\User;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;

class BlogPostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Article')
                    ->description('Titre, contenu et image de couverture de l\'article.')
                    ->schema([
                        TextInput::make('title')
                            ->label('Titre')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state) {
                                if (($get('slug') ?? '') !== Str::slug($old)) {
                                    return;
                                }

                                $set('slug', Str::slug($state));
                            }),
                        TextInput::make('slug')
                            ->label('Slug URL')
                            ->prefixIcon(Heroicon::OutlinedLink)
                            ->unique(ignoreRecord: true),
                        FileUpload::make('cover_image')
                            ->label('Image de couverture')
                            ->image()
                            ->disk('public')
                            ->directory('blog'),
                        Textarea::make('excerpt')
                            ->label('Résumé / Extrait')
                            ->rows(2)
                            ->maxLength(500),
                        RichEditor::make('content')
                            ->label('Contenu')
                            ->required()
                            ->toolbarButtons([
                                'bold', 'italic', 'underline', 'strike',
                                'h2', 'h3', 'bulletList', 'orderedList',
                                'blockquote', 'link', 'attachFiles',
                            ]),
                    ]),

                Section::make('Classification')
                    ->description('Catégorie, tags et auteur de l\'article.')
                    ->columns(['default' => 1, 'sm' => 2])
                    ->schema([
                        Select::make('blog_category_id')
                            ->label('Catégorie')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                TextInput::make('name')->required(),
                            ]),
                        Select::make('tags')
                            ->label('Tags')
                            ->relationship('tags', 'name')
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                TextInput::make('name')->required(),
                            ]),
                        Select::make('author_id')
                            ->label('Auteur')
                            ->options(fn () => User::consultants()->pluck('name', 'id'))
                            ->default(fn () => auth()->id())
                            ->required(),
                    ]),

                Section::make('Publication')
                    ->description('Statut, date de publication et référencement SEO.')
                    ->columns(['default' => 1, 'sm' => 2])
                    ->schema([
                        Select::make('status')
                            ->label('Statut')
                            ->options([
                                'draft' => 'Brouillon',
                                'published' => 'Publié',
                                'archived' => 'Archivé',
                            ])
                            ->default('draft')
                            ->required(),
                        DateTimePicker::make('published_at')
                            ->label('Date de publication'),
                        Toggle::make('is_featured')
                            ->label('Article à la une')
                            ->inline(false),
                        TextInput::make('meta_title')
                            ->label('Titre SEO')
                            ->prefixIcon(Heroicon::OutlinedMagnifyingGlass),
                        Textarea::make('meta_description')
                            ->label('Description SEO')
                            ->rows(2),
                    ]),
            ]);
    }
}
