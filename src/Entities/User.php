<?php

namespace Portico\RunKeeper\Entities;

/**
 * @property-read string fitness_activities
 */
class User
{
    use Readable;

    /** @var string */
    private $settings;

    /** @var string records endpoint */
    private $records;

    /** @var string profile endpoint */
    private $profile;

    /** @var string change log endpoint */
    private $change_log;

    /** @var string strength training activities endpoint */
    private $strength_training_activities;

    /** @var string weight endpoint */
    private $weight;

    /** @var string fitness activties endpoint */
    private $fitness_activities;

    /** @var string background activities endpoint */
    private $background_activities;

    /** @var string team endpoint */
    private $team;

    /** @var string sleep endpoint */
    private $sleep;

    /** @var string nutrition endpoint */
    private $nutrition;

    /** @var string diabetes endpoint */
    private $diabetes;

    /** @var int User's id */
    private $user_id;
}
