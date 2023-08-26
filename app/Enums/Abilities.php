<?php

namespace App\Enums;

enum Abilities
{
    case LIST_POSTS;
    case CREATE_POSTS;
    case EDIT_POSTS;
    case DELETE_POSTS;
    case PUBLISH_POSTS;

    case LIST_CATEGORIES;
    case CREATE_CATEGORIES;
    case EDIT_CATEGORIES;
    case DELETE_CATEGORIES;

    case LIST_BANNERS;
    case CREATE_BANNERS;
    case EDIT_BANNERS;
    case DELETE_BANNERS;
}
