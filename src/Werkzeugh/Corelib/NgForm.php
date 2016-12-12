<?php namespace Werkzeugh\Corelib;

class NgForm
{

  var $settings=[
    'model'=>'record',
  ];

  public function createField($conf)
  {

    return new NgFormField($this->getCurrentForm(),$conf);
  }

  public function getCurrentForm()
  {

    return $this;

  }


  public function set($key,$value)
  {
      return array_set($this->settings,$key,$value);
  }

  public function conf($key)
  {
      return array_get($this->settings,$key);
  }

}

class NgFormField
{
  var $p=[];

  public function __construct($parent,$conf)
  {
    $this->parent=$parent;
    if(!$conf['type']) {
      $conf['type']='text';
    }
    $this->p=$conf;
  }

  public function normalizedFieldname()
  {

    return snake_case($this->p['fieldname']); 
  }

  public function coreHtml()
  {
    $normalizedFieldname=$this->normalizedFieldname();
    $p=$this->p;


    $basename=$this->parent->conf('model');

    $modelName="{$basename}.{$p['fieldname']}";

    if ($p['styles']) {
      $styles=$p['styles'].";";
    }

    $addon_classes.=$p['addon_classes'];

    $tag_addon=$p['tag_addon'];

    if (is_array($p['jsdata'])) {
      $tag_addon.=" data-jsdata='".json_encode($p['jsdata'])."' ";
    }

    if ($p['placeholder']) {
      $tag_addon.=" placeholder=\"".str_replace('"','&quot;',$p['placeholder'])."\" ";
    }

    if ($p['type']=="html") {
      $field=$p['html'];
    }


    if ($p['type']=="text" || $p['type']=="number") {
      $defval=str_replace('"',"&quot;",$defval);
      $field="<input type='{$p['type']}' name='{$normalizedFieldname}' id='input_{$normalizedFieldname}' 
      style='$styles' ng-model=\"$modelName\" class=\"form-control $addon_classes\" $tag_addon>";
    }

    if ($p['type']=="submit") {

      $iconclass=$p['iconclass'];
      if(!$iconclass) {
        $iconclass="fa fa-check";
      }
      $btnText=$p['label'];
      if(!$btnText) {
        $btnText="OK";
      }

      $field="<button type=\"submit\" id='input_{$normalizedFieldname}' 
      style='$styles' class=\"form-control btn btn-primary\" $tag_addon ><i class='$iconclass'></i> $btnText</button>";
    }

    if ($p['type']=="password") {
      $field="<input  ng-model=\"$modelName\" type='password' name='{$normalizedFieldname}' id='input_{$normalizedFieldname}' style='$styles' class=\"form-control $addon_classes\" $tag_addon >";
    }

    if ($p['type']=="textarea") {

      $field="<textarea type=text name='{$normalizedFieldname}' id='input_{$normalizedFieldname}'
      style='$styles'  ng-model=\"$modelName\" class=\"form-control $addon_classes\" $tag_addon ></textarea>";
    }

    if ($p['type']=="checkbox") {

      $field.="<input type=\"checkbox\"  ng-model=\"$modelName\" name='{$normalizedFieldname}'  id='input_{$normalizedFieldname}' style='{$styles}' class=\"form-control {$addon_classes}\" $tag_addon  {$p['add2tag']}>";

    }

    if ($p['type']=="select") {

      $optionsString="";
      foreach ($p['options'] as $key => $value) {
        $optionsString.="<option value=\"$key\">$value</option>";
      }

      $field="<select  name='{$normalizedFieldname}' id='input_{$normalizedFieldname}'
      style='$styles'  ng-model=\"$modelName\" class=\"form-control $addon_classes\" $tag_addon >$optionsString</select>";

    }

    if ($p['after'])
      $field.=" ".$p['after']." ";

    if ($p['before'])
      $field=$p['before']." ".$field;

    return $field;

  }

  public function html()
  {

    $normalizedFieldname=$this->normalizedFieldname();
    $p=$this->p;

    $label=$p['label']?$p['label']:$p['fieldname'];
    if ($p[html]) {
      $field=$p[html];
    } else {
      $field=$this->coreHtml();
    }

    if($p['note']) {
      $note="<p class=\"help-block\">{$p['note']}</p>";
    }

    if($p['type']=="checkbox" ) {

      $html="
      <div class=\"checkbox formitem-{$normalizedFieldname}\">
        <label for=\"input_{$p['fieldname']}\" >
          $field
          $label
        </label>    
        $note
      </div> 
      ";

      $html="
      <div class=\"form-group formitem-{$normalizedFieldname}\">
        <span class='control-label'></span>
        <div class=\"form-control-wrap\">$html</div>
      </div>
      ";
    } elseif($p['type']=="hidden" && !$label ) {
      $html=$field;
    } else {
      if( $p['type']!="submit" && $label && $p['label']!='none') {
        $label="<label class='control-label'>$label</label>";
      } else {
        $label="";
      }

      if($p['width']) {
        $fg_style_addons[]="width:".$p['width'];
      }
      if($fg_style_addons) {
        $fg_style_addon_tag='style="'.implode(';',$fg_style_addons).'"';            
      }

      if ($p['postfix'] || $p['prefix']) {
        if ($p['postfix']) {
          $postfix="<span class=\"input-group-addon\">{$p['postfix']}</span>";
        }
        if ($p['prefix']) {
          $prefix="<span class=\"input-group-addon\">{$p['prefix']}</span>";
        }
      }

      if( $prefix || $postfix ) {
        $field="<div class=\"input-group\"  $fg_style_addon_tag>$prefix$field$postfix</div>";
      }elseif( $fg_style_addon_tag) {
        $field="<div $fg_style_addon_tag>$field</div>";
      }

      $field="<div class=\"form-control-wrap\">$field$note</div>";

      $html="
      <div class=\"form-group formitem-{$normalizedFieldname}\">
        $label
        $field
      </div>
      ";
    }
    return $html;    
  }

}
