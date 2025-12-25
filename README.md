# HopekellDev Core

[![PHP Version](https://img.shields.io/badge/PHP-%3E=_8.2-brightgreen.svg)](https://www.php.net/)
[![Laravel Version](https://img.shields.io/badge/Laravel-10%7C11-orange.svg)](https://laravel.com/)
[![MySQL Version](https://img.shields.io/badge/MySQL-%3E=_5.7-blue.svg)](https://www.mysql.com/)
[![Composer Version](https://img.shields.io/badge/Composer-%3E=_2.5-lightgrey.svg)](https://getcomposer.org/)
[![cURL](https://img.shields.io/badge/cURL-enabled-green.svg)](https://curl.se/)

**HopekellDev Core** is a Laravel library designed to provide essential functionality for CodeCanyon scripts, including:

- Installation wizard  
- License verification via Envato  
- Database import  
- File uploading and image processing  
- Module management  

This package works directly from the `vendor` folder without publishing controllers, routes, or views to the main Laravel application.

---

## Features

- **Installer**  
  - Multi-step installation for your scripts  
  - Purchase code verification via Envato  
  - Database connection verification  
  - Remote SQL import for initial setup  
  - Installation lock mechanism (`HOPEKELLDEV.LIV`) in `vendor/hopekell-dev/core/storage`

- **License Management**  
  - Verify license from your server  
  - Lock installation after verification  
  - Revalidation support if license file is deleted  

- **Uploader**  
  - Secure file uploads  
  - Image processing support  

- **Modules**  
  - Module management for your scripts  
  - Supports contracts for custom module development  

- **Helpers & Support**  
  - Common helpers  
  - Environment writer  
  - Utility functions for scripts  

---

## Installation

1. Require the package via Composer:

```bash
composer require hopekell-dev/core
