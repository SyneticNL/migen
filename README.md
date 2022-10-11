# Laravel Migator

![Laravel Migator personified as Arnold Schwarzenegger in Terminator](https://scontent-ams2-1.xx.fbcdn.net/v/t39.30808-6/277566413_369133498558681_7312429908945278869_n.png?_nc_cat=108&ccb=1-7&_nc_sid=e3f864&_nc_ohc=-HGg91wVyroAX-j4LpE&_nc_ht=scontent-ams2-1.xx&oh=00_AT8284yIQkTdrmByJJ3xRyu3buR-RqVdeWmH0ZBcTzy8tw&oe=634A4458 "The Migator will be back!")

A package that will allow developers to interactively generate schema migrations for a laravel application.

This package will ask the developer interactively for the following:

- [ ] model
- [x] table (default: derived from laravel model naming convention)
- [x] fields (repeatedly)
    - [x] name 
    - [x] type
        - [x] boolean
        - [x] text
        - [x] date
        - [x] datetime
        - [ ] json
        - [ ] id
        - [x] integer
    - [ ] default value
    - [ ] index
    - [ ] foreignkeys
- [ ] relations to other entities

It will then ask for writing this into a migration file.

## Installation

This package can be installed using composer:

```bash
composer require synetic/migator --dev
```

## Usage

`php artisan make:migator`

This will start the migator process.

## Roadmap

- [ ] Derive table name default from the given model
- [ ] Implement validation of preexisting columns / definitions
- [ ] Implement CLI usage for 'model'-specific use case (#5)
- [ ] Implement CLI usage for 'other' use case (#6)
- [ ] Implement relation mapping / autocomplete
- [ ] Optionally specify the stub to be used for the migration