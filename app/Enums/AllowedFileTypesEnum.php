<?php


namespace App\Enums;


class AllowedFileTypesEnum{

    const ALLOWED_MIME_TYPES = [
        'application/pdf',
        'image/bmp',
        'image/jpeg',
        'image/png',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'application/vnd.ms-powerpoint',
        'application/vnd.openxmlformats-officedocument.presentationml.presentation',
    ];

    const ALLOWED_EXTENSIONS = [
        'pdf',
        'bmp',
        'jpeg',
        'jpg',
        'png',
        'doc',
        'docx',
        'xls',
        'xlsx',
        'ppt',
        'pptx'
    ];

}