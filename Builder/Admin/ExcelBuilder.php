<?php

namespace Admingenerator\GeneratorBundle\Builder\Admin;

/**
 * This builder generates php for list actions
 *
 * @author cedric Lombardot
 * @author Piotr Gołębiewski <loostro@gmail.com>
 * @author Bob van de Vijver
 */
class ExcelBuilder extends ListBuilder
{
  /**
   * @var array
   */
  protected $export = null;

  /**
   * (non-PHPdoc)
   * @see Admingenerator\GeneratorBundle\Builder.BaseBuilder::getYamlKey()
   */
  public function getYamlKey()
  {
    return 'excel';
  }

  public function getFileName(){
    if(null === ($filename = $this->getVariable('filename'))){
      $filename = 'admin_export_'. str_replace(' ', '_', strtolower($this->getGenerator()->getFromYaml('builders.list.params.title')));
    }
    return $filename;
  }

  public function getFileType(){
    if(null === ($filetype = $this->getVariable('filetype'))){
      $filetype = 'Excel2007';
    }
    return $filetype;
  }

  public function getDateTimeFormat(){
    if(null === ($dateTimeFormat = $this->getVariable('datetime_format'))){
      $dateTimeFormat = 'Y-m-d H:i:s';
    }
    return $dateTimeFormat;
  }

  /**
   * Return a list of columns from excel.export
   * 
   * In YAML config should looks like this:
   *   excel:
   *     params: 
   *       export: 
   *         full:
   *           -       id
   *           -       title
   *           -       code
   *           -       guid
   *           -       note
   *         short:
   *           -       id
   *           -       code
   *           -       title
   *         simple:
   *           -       title
   * 
   * @return array
   */
  public function getExport()
  {
      if (null === $this->export) {
          $this->export = array();
          $this->fillExport();
      }

      return $this->export;
  }

  protected function fillExport()
  {
      $export = $this->getVariable('export',[]);
      if (!count($export)) return [];

      foreach ($export as $keyName => $columns ) {
          $this->export[$keyName] = [];
          foreach ($columns as $columnName) {
              $column = $this->createColumn($columnName, false);
              $this->setUserColumnConfiguration($column);              
              $this->export[$keyName][$columnName] = $column;
          }
      }
  }

}
