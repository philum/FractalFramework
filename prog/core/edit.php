<?php

class edit{

static function del($p){
$table=val($prm,'table'); $id=val($p,'id');
sqldel($table,$id);
return 'ok';}

/*static function edit($p){
$p['table']='slides';
$p['cols']='bid,txt,rel';
$p['act']='modif';
$ret=edit::com($p);	
return $ret;}*/

static function modif($p){
$table=val($p,'table'); $cols=val($p,'cols'); $id=val($p,'id');
$cl=explode(';',$cols);
foreach($cl as $v)$r[$v]=$p[$v];
sqlups($table,$r,$id);
return 'ok';}

/*static function add($p){
$p['table']='slides';
$p['act']='add';
$ret=edit::com($p);	
return $ret;}*/

static function add($p){
$table=val($prm,'table'); $cols=val($p,'cols'); $id=val($p,'id');
$r=sqlcols($table,2); $cols=implode(',',array_keys($r));
if($r)foreach($r as $k=>$v)$ret[$k]=val($p,$k);
$nid=sqlsav($table,$ret);
return $nid;}

static function com($p){$ret='';
$rid=randid('txt'); $table=val($p,'table'); $cols=val($p,'cols'); 
$id=val($p,'id'); $act=val($p,'act'); $labs=val($p,'colslabels');
if($cols){$cl=explode(',',$cols);if($labs)$lb=array_combine($cl,explode(',',$labs));}
else{$cl=sqlcols($table,2); $cols=implode(',',array_keys($cl)); $p['cols']=$cols;}
if($id)$r=sql($cols,$table,'ra','where id='.$id);
$prm='id='.$id.',table='.$table.',cols='.str_replace(',',';',$cols);
if(isset($r))foreach($r as $k=>$v){
	$label=label($k,isset($lb[$k])?lang($lb[$k]):$k);
	$ret.=div(goodinput($k,$v).' '.$label);}
$ret.=aj($rid.'|edit,'.$act.'|'.$prm.'|'.$cols,langp($act),'btsav');
return div($ret,'',$rid);}

}
?>