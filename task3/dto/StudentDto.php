<?php

namespace task3\dto;

class StudentDto
{
    public int $id;
    public string $lastName;
    public string $firstName;
    public ?string $patronymic;
    public ?string $email;
    public ?string $dateOfBirth;
}