<?php

namespace App\Service\Abstracts;

interface IBaseService
{
    function find();

    function findAll();

    function create();

    function update();

    function delete();

    function setStatus();
}