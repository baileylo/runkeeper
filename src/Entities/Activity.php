<?php

namespace Portico\RunKeeper\Entities;

/**
 * @property-read string uri
 */
class Activity
{
    use Readable;

    /** @var integer */
    private $utc_offset;

    /** @var float */
    private $duration;

    /** @var \DateTime */
    private $start_time;

    /** @var int */
    private $total_calories;

    /** @var string */
    private $tracking_mode;

    /** @var string */
    private $entry_mode;

    /** @var bool */
    private $has_path;

    /** @var string */
    private $source;

    /** @var string */
    private $type;

    /** @var string */
    private $uri;
}
