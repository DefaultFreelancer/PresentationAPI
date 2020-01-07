#!/bin/bash

echo "======== PHP Entrypoint ==========="

mkdir -p /import
mkdir -p /import/abbyy
mkdir -p /import/custom
mkdir -p /import/custom/single
mkdir -p /import/custom/multiple
mkdir -p /import/mets_ccs
mkdir -p /import/novodynamics
mkdir -p /import/pdf
mkdir -p /import/pdf_multiple
mkdir -p /import/video

mkdir -p /storage
mkdir -p /storage/storage
mkdir -p /storage/tmp
mkdir -p /storage/var
mkdir -p /storage/upload
mkdir -p /storage/files
mkdir -p /storage/cache
mkdir -p /storage/cache/tmp
chown -R www-data:www-data /storage

/usr/sbin/php-fpm7.2 -F
