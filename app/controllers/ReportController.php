<?php

  class ReportController extends BaseController{
    
    public function index(){
      return View::make('report.index');
    }
    
  }