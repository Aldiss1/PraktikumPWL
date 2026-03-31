<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Models\Category;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
                Section::make('Post Details')
                    ->description('Fill in the details of the post')
                    // ->icon(Heroicon::RocketLaunch)
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        // grouping fields into 2 columns
                        Group::make([
                            TextInput::make('title')
                                ->required()
                                ->minLength(5)
                                ->validationMessages([
                                    'required' => 'Judul Postingan wajib diisi.',
                                    'min' => 'Judul harus terdiri dari minimal 5 karakter.',
                                ]),
                            TextInput::make('slug')
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->minLength(3)
                                ->validationMessages([
                                    'unique' => 'Slug harus unik.',
                                ]),
                            Select::make('category_id')
                                ->required()
                                ->validationMessages([
                                    'required' => 'Silakan pilih Kategori untuk Post ini.',
                                ])
                                ->relationship('category', 'name')
                                ->options(Category::all()->pluck('name', 'id'))
                                // ->preload()
                                ->searchable(),
                            ColorPicker::make('color'),
                        ])->columns(2),
                        MarkdownEditor::make('body'),
                    ])->columnSpan(2),
                // RichEditor::make("body"),
                // Grouping fields into 2 columns
                Group::make([
                    // section 2 - image
                    Section::make('Image Upload')
                        ->icon('heroicon-o-photo')
                        ->schema([
                            FileUpload::make('image')
                                ->required()
                                ->disk('public')
                                ->directory('posts'),
                        ]),

                    // section 3 - meta
                    Section::make('Meta Information')
                        ->icon('heroicon-o-tag')
                        ->schema([
                            TagsInput::make('tags'),
                            Checkbox::make('published'),
                        ])->columns(2),
                    DateTimePicker::make('published_at'),
                ])->columnSpan(1),
            ])->columns(3);
    }
}
