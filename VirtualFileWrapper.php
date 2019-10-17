<?php
/**
 * Virtual file wrapper class file
 */
class VirtualFileWrapper {

    /**
     * Context variable
     *
     * @var resource
     */
    public $context;

    /**
     * Current position of the stream
     *
     * @var integer
     */
    protected $position = 0;

    /**
     * Chosen stream name
     *
     * @var string
     */
    protected $stream;

    /**
     * Stream contents
     *
     * @var mixed
     */
    protected static $contents;

    /**
     * Open a file or url
     *
     * @param string  $path Specifies the URL that was passed to the original function.
     * @param string  $mode The mode used to open the file, as detailed for fopen().
     * @param integer $options Holds additional flags set by the streams API.
     * @param string  $opened_path Should be set to the full path of the file/resource that was actually opened.
     * @return bool
     */
    public function stream_open( string $path, string $mode, int $options, ?string &$opened_path ) : bool {
        $url            = parse_url( $path );
        $this->stream   = $url['host'];
        $this->position = 0;

        return true;
    }

    /**
     * Retrieve information about a file resource
     *
     * @return array
     */
    public function stream_stat() : array {
        return [
            0         => 0,
            1         => 0,
            2         => 0,
            3         => 0,
            4         => 0,
            5         => 0,
            6         => 0,
            7         => 0,
            8         => 0,
            9         => 0,
            10        => 0,
            11        => 0,
            12        => 0,
            13        => 0,
            'dev'     => 0,
            'ino'     => 0,
            'mode'    => 0,
            'nlink'   => 0,
            'uid'     => 0,
            'gid'     => 0,
            'rdev'    => 0,
            'size'    => 0,
            'atime'   => 0,
            'mtime'   => 0,
            'ctime'   => 0,
            'blksize' => 0,
            'blocks'  => 0,
        ];
    }


    /**
     * Undocumented function
     *
     * @param string  $path The file path or URL to stat.
     * @param integer $flags Holds additional flags set by the streams API.
     * @return array
     */
    public function url_stat( string $path, int $flags ) : array {
        return [
            0         => 0,
            1         => 0,
            2         => 0,
            3         => 0,
            4         => 0,
            5         => 0,
            6         => 0,
            7         => 0,
            8         => 0,
            9         => 0,
            10        => 0,
            11        => 0,
            12        => 0,
            13        => 0,
            'dev'     => 0,
            'ino'     => 0,
            'mode'    => 0,
            'nlink'   => 0,
            'uid'     => 0,
            'gid'     => 0,
            'rdev'    => 0,
            'size'    => 0,
            'atime'   => 0,
            'mtime'   => 0,
            'ctime'   => 0,
            'blksize' => 0,
            'blocks'  => 0,
        ];
    }

    /**
     * Read from stream
     *
     * @param integer $count How many bytes of data from the current position should be returned.
     * @return string
     */
    public function stream_read( int $count ) : string {
        $return          = substr( static::$contents[ $this->stream ], $this->position, $count );
        $this->position += strlen( $return );
        return $return;
    }

    /**
     * Write to stream
     *
     * @param string $data Should be stored into the underlying stream.
     * @return integer
     */
    public function stream_write( string $data ) : int {
        $length                            = strlen( $data );
        static::$contents[ $this->stream ] = substr( static::$contents[ $this->stream ], 0, $this->position ) . $data . substr( static::$contents[ $this->stream ], $this->position += $length );
        return $length;
    }


    /**
     * Tests for end-of-file on a file pointer
     *
     * @return boolean
     */
    public function stream_eof() : bool {
        return $this->position >= strlen( static::$contents[ $this->stream ] );
    }

    /**
     * Retrieve the current position of a stream
     *
     * @return int
     */
    public function stream_tell() : int {
        return $this->position;
    }

    /**
     * Seeks to specific location in a stream
     *
     * @param int $offset The stream offset to seek to.
     * @param int $whence SEEK_SET | SEEK_CUR | SEEK_END.
     * @return bool
     */
    public function stream_seek( int $offset, int $whence ) : bool {
        $length = strlen( static::$contents[ $this->stream ] );

        switch ( $whence ) {
            case SEEK_SET:
                $new_position = $offset;
                break;
            case SEEK_CUR:
                $new_position = $this->position + $offset;
                break;
            case SEEK_END:
                $new_position = $length + $offset;
                break;
            default:
                return false;
        }

        $return = ( $new_position >= 0 && $new_position <= $length );

        if ( $return ) {
            $this->position = $new_position;
        }

        return $return;
    }
}
