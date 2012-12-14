<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

// set spark version
define('QR_VERSION', '0.0.1');

// Load the QR lib
require_once FCPATH.'sparks/qr/' .QR_VERSION. '/vendor/qrlib.php';

// main class
class QR {
  
    private $rawData;

    private $encoder;

    private $outputToBrowser = FALSE;
    private $errorCorrectionLevel = QR_ECLEVEL_L;
    private $matrixPointSize = 4;
    private $margin = 4;

    private $filename;

    /**
     * Constructor - Sets QR Preferences
     *
     * The constructor can be passed an array of config values
     */
    public function __construct($in_config = array())
    {
        if (count($in_config) > 0)
        {
            $this->initialize($in_config);
        }

        log_message('debug', "QR Class Initialized");
    }

    // --------------------------------------------------------------------

    /**
     * Initialize preferences
     *
     * @access  public
     * @param   array
     * @return  void
     */
    public function initialize($in_config = array())
    {
        foreach ($in_config as $key => $val)
        {
            if (property_exists($this, $key))
            {
                $method = 'set_'.$key;

                if (method_exists($this, $method))
                {
                    $this->$method($val);
                }
                else
                {
                    $this->$key = $val;
                }
            }
        }
        $this->clear();

        return $this;
    }

    // --------------------------------------------------------------------

    /**
     * Clear the Data
     *
     * @access  public
     * @return  void
     */
    public function clear()
    {
        $this->rawData = "";

        return $this;
    }

    public function set_errorCorrectionLevel($in_correctionLevel)
    {
        $newErrorCorrectionLevel = QR_ECLEVEL_L;

        $lowerCorrection = strtolower($in_correctionLevel);
        if (in_array($lowerCorrection, array('l','m','q','h')))
        {
            switch($lowerCorrection)
            {
                case 'l':
                    $newErrorCorrectionLevel = QR_ECLEVEL_L;
                    break;
                case 'm':
                    $newErrorCorrectionLevel = QR_ECLEVEL_M;
                    break;
                case 'q':
                    $newErrorCorrectionLevel = QR_ECLEVEL_Q;
                    break;
                case 'h':
                    $newErrorCorrectionLevel = QR_ECLEVEL_H;
                    break;
            }
        }
        else
        {
            log_message('debug', "QR::set_errorCorrectionLevel: Invalid Correction Level");
        }

        if($this->errorCorrectionLevel !== $newErrorCorrectionLevel)
        {
            $this->errorCorrectionLevel = $newErrorCorrectionLevel;

            // Invalidate the encoder if we're changing settings
            $this->encoder = NULL;
        }
    }

    public function set_matrixPointSize($in_size)
    {
        $newMatrixPointSize = 4;
        if($in_size <= 10 && $in_size >= 1)
        {
            $newMatrixPointSize = $in_size;
        }
        else
        {
            log_message('debug', "QR::set_matrixPointSize: Invalid Size");
        }

        if($this->matrixPointSize != $newMatrixPointSize)
        {
            $this->matrixPointSize = $newMatrixPointSize;

            // Invalidate the encoder if we're changing settings
            $this->encoder = NULL;
        }
    }

    public function set_margin($in_margin)
    {
        if($this->margin != $in_margin)
        {
            $this->margin = $in_margin;

            // Invalidate the encoder if we're changing settings
            $this->encoder = NULL;
        }
    }

    public function set_data($in_data)
    {
        $this->rawData = $in_data;
    }

    public function set_filename($in_filename)
    {
        $this->filename = $in_filename;
    }

    public function createEncoder()
    {
        $this->encoder = QRencode::factory($this->errorCorrectionLevel, $this->matrixPointSize, $this->margin);
    }

    public function encodePNG($in_data = "")
    {
        if($in_data != "")
        {
            $this->set_data($in_data);
        }

        if($this->encodeInitialize() == FALSE)
        {
            log_message('debug', "QR::encodeRaw: Cannot initialize encoding");
            return FALSE;
        }
        
        return $this->encoder->encodePNG($this->rawData, $this->filename, $this->outputToBrowser);
    }

    public function encodeText($in_data = "")
    {
        if($in_data != "")
        {
            $this->set_data($in_data);
        }
        
        if($this->encodeInitialize() == FALSE)
        {
            log_message('debug', "QR::encodeRaw: Cannot initialize encoding");
            return FALSE;
        }

        return $this->encoder->encode($this->rawData, $this->filename);
    }

    public function encodeRaw($in_data = "")
    {
        if($in_data != "")
        {
            $this->set_data($in_data);
        }
        
        if($this->encodeInitialize() == FALSE)
        {
            log_message('debug', "QR::encodeRaw: Cannot initialize encoding");
            return FALSE;
        }

        return $this->encoder->encodeRAW($this->rawData, $this->filename);
    }

    private function encodeInitialize()
    {
        if(is_null($this->encoder))
        {
            $this->createEncoder();
        }
        
        return TRUE;
    }
    
}