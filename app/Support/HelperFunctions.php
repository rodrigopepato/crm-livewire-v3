<?php

use App\Models\User;

function user(): ?User
{
    if(auth()->check()) {

        return auth()->user();
    }

    return null;
}

function obfuscate_email(string $email): string
{

    $split = explode('@', $email);

    $firstPart       = $split[0];
    $qty             = (int)floor(strlen($firstPart) * 0.75);
    $remaining       = strlen($firstPart) - $qty;
    $maskedFirstPart = substr($firstPart, 0, $remaining) . str_repeat('*', $qty);

    $secondPart       = $split[1];
    $qty              = (int) floor(strlen($secondPart) * 0.75);
    $remaining        = strlen($secondPart) - $qty;
    $maskedSecondPart = str_repeat('*', $qty) . substr($secondPart, $remaining * -1, $remaining);

    return $maskedFirstPart . '@' . $maskedSecondPart;
}
