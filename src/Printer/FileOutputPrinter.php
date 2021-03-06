<?php

namespace miamioh\BehatCSVFormatter\Printer;

use Behat\Testwork\Output\Exception\BadOutputPathException;
use Behat\Testwork\Output\Printer\OutputPrinter as PrinterInterface;


/**
 * Class: FileOutputPrinter
 *
 * @see PrinterInterface
 */
class FileOutputPrinter implements PrinterInterface  {

      /**
       * @var string
       */
      private $path;
      /**
       * @var string
       */
      private $filename;

      /** @var array */
      private $options;


      /**
       * __construct
       *
       * @param string $filename
       * @param string $outputDir
       */
      public function __construct($filename, $outputDir,$options)
      {
          $this->filename = $filename;
          $this->setOutputPath($outputDir);
          $this->options = $options;
      }
      /**
       * setOutputPath
       *
       * @param string $outpath
       */
      public function setOutputPath($outpath)
      {
          if (!file_exists($outpath)) {
              if (!mkdir($outpath, 0755, true)) {
                  throw new BadOutputPathException(
                      sprintf(
                          'Output path %s does not exist and could not be created!',
                          $outpath
                      ),
                      $outpath
                  );
              }
          } else {
              if (!is_dir(realpath($outpath))) {
                  throw new BadOutputPathException(
                      sprintf(
                          'The argument to `output` is expected to the a directory, but got %s!',
                          $outpath
                      ),
                      $outpath
                  );
              }
          }
          $this->path = $outpath;
      }
      /**
       * Returns output path
       *
       * @return string path
       */
      public function getOutputPath()
      {
          return $this->path;
      }
      /**
       * @param array $styles
       */
      public function setOutputStyles(array $styles)
      {
      }
      /**
       * @return array
       */
      public function getOutputStyles()
      {
      }
      /**
       * @param Boolean $decorated
       */
      public function setOutputDecorated($decorated)
      {
      }
      /**
       * @return null|Boolean
       */
      public function isOutputDecorated()
      {
          return true;
      }
      /**
       * @param integer $level
       */
      public function setOutputVerbosity($level)
      {
      }
      /**
       * @return integer
       */
      public function getOutputVerbosity()
      {
          return 0;
      }
      /**
       * write
       *
       * @param mixed $messages
       * @param mixed $append
       */
      public function write($messages, $append = false)
      {
            $file = $this->getOutputPath() . DIRECTORY_SEPARATOR . $this->filename;
            $handle = fopen($file,'a');
            fputcsv ( $handle , $messages, $delimiter = $this->options['delimiter'], $enclosure = $this->options['enclosure'] );
            fclose($handle);
      }
      /**
       * writeln
       *
       * @param array $messages
       */
      public function writeln($messages = '')
      {
          $this->write($messages, true);
      }
      /**
       * flush
       *
       */
      public function flush()
      {
      }
      /**
       * Writes  message(s) at start of the output console.
       *
       * @param string|array $messages message or array of messages
       */
      public function writeHeaderRow($messages) {
        $file = $this->getOutputPath() . DIRECTORY_SEPARATOR . $this->filename;
        $handle = fopen($file,'w');
        fputcsv ( $handle , $messages, $delimiter = $this->options['delimiter'], $enclosure = $this->options['enclosure'] );
        fclose($handle);
      }


}
