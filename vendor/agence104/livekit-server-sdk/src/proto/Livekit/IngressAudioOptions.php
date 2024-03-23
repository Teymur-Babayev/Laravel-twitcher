<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: livekit_ingress.proto

namespace Livekit;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>livekit.IngressAudioOptions</code>
 */
class IngressAudioOptions extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string name = 1;</code>
     */
    protected $name = '';
    /**
     * Generated from protobuf field <code>.livekit.TrackSource source = 2;</code>
     */
    protected $source = 0;
    /**
     * desired mime_type to publish to room
     *
     * Generated from protobuf field <code>string mime_type = 3;</code>
     */
    protected $mime_type = '';
    /**
     * Generated from protobuf field <code>uint32 bitrate = 4;</code>
     */
    protected $bitrate = 0;
    /**
     * Generated from protobuf field <code>bool disable_dtx = 5;</code>
     */
    protected $disable_dtx = false;
    /**
     * Generated from protobuf field <code>uint32 channels = 6;</code>
     */
    protected $channels = 0;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $name
     *     @type int $source
     *     @type string $mime_type
     *           desired mime_type to publish to room
     *     @type int $bitrate
     *     @type bool $disable_dtx
     *     @type int $channels
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\LivekitIngress::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>string name = 1;</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Generated from protobuf field <code>string name = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setName($var)
    {
        GPBUtil::checkString($var, True);
        $this->name = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>.livekit.TrackSource source = 2;</code>
     * @return int
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Generated from protobuf field <code>.livekit.TrackSource source = 2;</code>
     * @param int $var
     * @return $this
     */
    public function setSource($var)
    {
        GPBUtil::checkEnum($var, \Livekit\TrackSource::class);
        $this->source = $var;

        return $this;
    }

    /**
     * desired mime_type to publish to room
     *
     * Generated from protobuf field <code>string mime_type = 3;</code>
     * @return string
     */
    public function getMimeType()
    {
        return $this->mime_type;
    }

    /**
     * desired mime_type to publish to room
     *
     * Generated from protobuf field <code>string mime_type = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setMimeType($var)
    {
        GPBUtil::checkString($var, True);
        $this->mime_type = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>uint32 bitrate = 4;</code>
     * @return int
     */
    public function getBitrate()
    {
        return $this->bitrate;
    }

    /**
     * Generated from protobuf field <code>uint32 bitrate = 4;</code>
     * @param int $var
     * @return $this
     */
    public function setBitrate($var)
    {
        GPBUtil::checkUint32($var);
        $this->bitrate = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>bool disable_dtx = 5;</code>
     * @return bool
     */
    public function getDisableDtx()
    {
        return $this->disable_dtx;
    }

    /**
     * Generated from protobuf field <code>bool disable_dtx = 5;</code>
     * @param bool $var
     * @return $this
     */
    public function setDisableDtx($var)
    {
        GPBUtil::checkBool($var);
        $this->disable_dtx = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>uint32 channels = 6;</code>
     * @return int
     */
    public function getChannels()
    {
        return $this->channels;
    }

    /**
     * Generated from protobuf field <code>uint32 channels = 6;</code>
     * @param int $var
     * @return $this
     */
    public function setChannels($var)
    {
        GPBUtil::checkUint32($var);
        $this->channels = $var;

        return $this;
    }

}
