<?php

namespace App\Helpers;

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

class Datatable
{

  public static $request;
  public static $query;
  public static $records_total;
  public static $records_filtered;

  static function make($request, $model)
  {
    self::$request = $request;
    self::$query = $model;
    self::setRecordsTotal();
    self::filterRec();
    self::filter();
    self::setRecordsFiltered();
    self::orderLimit();
    $data = self::renderJson();
    return $data;
  }

  // set total record count
  static function setRecordsTotal()
  {
    self::$records_total = self::$query->count();
  }

  // filter by search query
  static function filter()
  {
    if (!empty(self::$request['search']['value'])) {

      $self = self::$request;

      self::$query->where(function ($q) use ($self) {

        foreach ($self['columns'] as $column) {
          if ($column['searchable'] == 'true') {
            $q->orWhere($column['data'], 'like', '%' . $self['search']['value'] . '%');
          }
        }
      });
    }
  }
  // filter by search query
  static function filterRec()
  {
    $self = self::$request;
    self::$query->where(function ($q) use ($self) {
      if (isset($self['columns'])) {
        foreach ($self['columns'] as $column) {
          if ($column['search']['value'] != "") {
            if ($column['searchable'] == 'true') {
              $chk = explode(".", $column['data']);

              if (count($chk) > 1) {
                $last = array_pop($chk);
                $chk = implode(".", $chk);
                $vl = $column['search']['value'];
                $q->whereHas($chk, function ($qs) use ($last, $vl) {
                  $qs->where($last, 'like', '%' . $vl . '%');
                });
              } else {
                $q->where($column['data'], 'like', '%' . $column['search']['value'] . '%');
              }
            }
          }
        }
      }
    });
  }

  // public function childWhere()
  // {
  //   if (count($chk) > 0) {
  //     $last = array_pop($chk);
  //     $chk = implode(".", $chk);
  //     $vl = self::$request['search']['value'];
  //     $q->whereHas($chk, function ($qs) use ($last, $vl) {
  //       $qs->where($last, $vl);
  //     });
  //   }
  // }

  // set filtered record count
  static function setRecordsFiltered()
  {
    self::$records_filtered = self::$query->count();
  }

  // apply order by & limit
  static function orderLimit()
  {
    if (isset(self::$request['columns'][self::$request['order'][0]['column']]['name'])) {
      self::$query->orderBy(self::$request['columns'][self::$request['order'][0]['column']]['name'], self::$request['order'][0]['dir']);
      if (self::$request['length'] != "-1") {
        self::$query->skip(self::$request['start'])->take(self::$request['length']);
      }
    }
  }

  // render json output
  static function renderJson()
  {
    $array = array();
    $array['draw'] = self::$request['draw'];
    $array['recordsTotal'] = self::$records_total;
    $array['recordsFiltered'] = self::$records_filtered;
    $array['data'] = array();
    $results = self::$query->get();

    // dump($results);
    // die();

    if (count(get_class_methods($results)) > 0) {
      $results = $results->toArray();
    }

    foreach ($results as $result) {
      $array['data'][] = (array) $result;
    }
    return ($array);
  }
}
