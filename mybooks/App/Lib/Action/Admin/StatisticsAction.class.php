<?php
class StatisticsAction extends CommonAction {

    public function classification(){
    	$class = M('bookclass')->select();
    	foreach($class as $key=>$value){
    		$item['name'] = $value['typename'];
    		$item['count1'] = M('books')->where("book_class='".$value['typename']."' and book_level=1")->count();
    		$item['count2'] = M('books')->where("book_class='".$value['typename']."' and book_level=2")->count();
    		$item['count3'] = M('books')->where("book_class='".$value['typename']."' and book_level=3")->count();
    		$item['count4'] = M('books')->where("book_class='".$value['typename']."' and book_level=4")->count();
    		$item['count5'] = M('books')->where("book_class='".$value['typename']."' and book_level=5")->count();
    		$item['count6'] = M('books')->where("book_class='".$value['typename']."' and book_level=6")->count();
    		$data[] = $item;
    	}
    	$this->assign('data',$data);
	   	$this->display();
    }

    public function theme(){
    	//设定每个年级的测试次数
    	$count= M('test_school')
            ->field("count(*) as count,schid")
            ->group("schid")
            ->order("count desc")
            ->limit('1')
            ->find();
        $n = $count['count'];

        $sum1 = M('books')->where("books.book_level = 4")->count();
        $sum2 = M('books')->where("books.book_level = 5")->count();
        $sum3 = M('books')->where("books.book_level = 6")->count();
        $sum['title'] = '总数';
        $sum['count1'] = $sum1;
        $sum['count2'] = $sum2;
        $sum['count3'] = $sum3;
        $sum['lack1'] = '';
        $sum['lack2'] = '';
        $sum['lack3'] = '';
    	$theme = M('booktopic')->select();
    	foreach($theme as $key=>$value){
    		$item['title'] = $value['title'];
    		$item['count1'] = M('books')->where("book_topic='".$value['title']."' and book_level=4")->count();
    		$item['count2'] = M('books')->where("book_topic='".$value['title']."' and book_level=5")->count();
    		$item['count3'] = M('books')->where("book_topic='".$value['title']."' and book_level=6")->count();
    		$item['lack1'] = $n*4-$item['count1'];
    		$item['lack2'] = $n*4-$item['count2'];
    		$item['lack3'] = $n*4-$item['count3'];
    		
    		$data[] = $item;
    	}
        //var_dump($data);die;
        $data[] = $sum;
    	$this->assign('data',$data);
	   	$this->display();
    }

    public function label(){
    	//设定每个年级的测试次数
    	$count= M('test_school')
            ->field("count(*) as count,schid")
            ->group("schid")
            ->order("count desc")
            ->limit('1')
            ->find();
        $n = $count['count'];

        $sum1 = M('books')->where("books.book_level = 1")->count();
        $sum2 = M('books')->where("books.book_level = 2")->count();
        $sum3 = M('books')->where("books.book_level = 3")->count();
        $sum['name'] = '总数';
        $sum['count1'] = $sum1;
        $sum['count2'] = $sum2;
        $sum['count3'] = $sum3;
        $sum['lack1'] = '';
        $sum['lack2'] = '';
        $sum['lack3'] = '';

    	$label = M('booklabel')->where("title != '其它'")->select();
    	foreach($label as $key=>$value){
    		$item['name'] = $value['title'];
    		$item['count1'] = M('tags')->join('books on tags.bid=books.id','inner')->where("books.book_level=1 and tags.tag_name='".$value['title']."'")->count();
    		$item['count2'] = M('tags')->join('books on tags.bid=books.id','inner')->where("books.book_level=2 and tags.tag_name='".$value['title']."'")->count();
    		$item['count3'] = M('tags')->join('books on tags.bid=books.id','inner')->where("books.book_level=3 and tags.tag_name='".$value['title']."'")->count();
    		$item['lack1'] = $n*4-$item['count1'];
    		$item['lack2'] = $n*4-$item['count2'];
    		$item['lack3'] = $n*4-$item['count3'];
    		
    		$data[] = $item;
            //其它标签书籍
            $sum1 -= $item['count1'];
            $sum2 -= $item['count2'];
            $sum3 -= $item['count3'];
    	}
        $other['name'] = '其它';
        $other['count1'] = $sum1;
        $other['count2'] = $sum2;
        $other['count3'] = $sum3;
        $other['lack1'] = $n*8-$other['count1'];
        $other['lack2'] = $n*8-$other['count2'];
        $other['lack3'] = $n*8-$other['count3'];
        $data[] = $other;
        $data[] = $sum;

        //$num = M('books')->where('book_level in (4,5,6)')->count();
        //var_dump($num);

        $this->assign('data',$data);
	   	$this->display();

    }

    //导出
     function expTheme(){//导出Excel
        $xlsName  = "主题统计";
       
        $xlsCell  = array(
        array('title','主题'),
        array('count1','四年级实际数量'),
        array('count2','五年级实际数量'),
        array('count3','六年级实际数量'),
        array('lack1','四年级缺少数量'),
        array('lack2','五年级缺少数量'),
        array('lack3','六年级缺少数量'),
        );
        $count= M('test_school')
            ->field("count(*) as count,schid")
            ->group("schid")
            ->order("count desc")
            ->limit('1')
            ->find();
        $n = $count['count'];

        $sum1 = M('books')->where("books.book_level = 4")->count();
        $sum2 = M('books')->where("books.book_level = 5")->count();
        $sum3 = M('books')->where("books.book_level = 6")->count();
        $sum['title'] = '总数';
        $sum['count1'] = $sum1;
        $sum['count2'] = $sum2;
        $sum['count3'] = $sum3;
        $sum['lack1'] = '';
        $sum['lack2'] = '';
        $sum['lack3'] = '';
        $theme = M('booktopic')->select();
        foreach($theme as $key=>$value){
            $item['title'] = $value['title'];
            $item['count1'] = M('books')->where("book_topic='".$value['title']."' and book_level=4")->count();
            $item['count2'] = M('books')->where("book_topic='".$value['title']."' and book_level=5")->count();
            $item['count3'] = M('books')->where("book_topic='".$value['title']."' and book_level=6")->count();
            $item['lack1'] = $n*4-$item['count1'];
            $item['lack2'] = $n*4-$item['count2'];
            $item['lack3'] = $n*4-$item['count3'];
            
            $xlsData[] = $item;
        }

        $this->exportExcel($xlsName,$xlsCell,$xlsData);
         
    }

    function expLabel(){//导出Excel
        $xlsName  = "标签1统计";
       
        $xlsCell  = array(
        array('name','标签1'),
        array('count1','一年级实际数量'),
        array('count2','二年级实际数量'),
        array('count3','三年级实际数量'),
        array('lack1','一年级缺少数量'),
        array('lack2','二年级缺少数量'),
        array('lack3','三年级缺少数量'),
        );
        $count= M('test_school')
            ->field("count(*) as count,schid")
            ->group("schid")
            ->order("count desc")
            ->limit('1')
            ->find();
        $n = $count['count'];

        $sum1 = M('books')->where("books.book_level = 1")->count();
        $sum2 = M('books')->where("books.book_level = 2")->count();
        $sum3 = M('books')->where("books.book_level = 3")->count();
        $sum['name'] = '总数';
        $sum['count1'] = $sum1;
        $sum['count2'] = $sum2;
        $sum['count3'] = $sum3;
        $sum['lack1'] = '';
        $sum['lack2'] = '';
        $sum['lack3'] = '';

        $label = M('booklabel')->where("title != '其它'")->select();
        foreach($label as $key=>$value){
            $item['name'] = $value['title'];
            $item['count1'] = M('tags')->join('books on tags.bid=books.id','inner')->where("books.book_level=1 and tags.tag_name='".$value['title']."'")->count();
            $item['count2'] = M('tags')->join('books on tags.bid=books.id','inner')->where("books.book_level=2 and tags.tag_name='".$value['title']."'")->count();
            $item['count3'] = M('tags')->join('books on tags.bid=books.id','inner')->where("books.book_level=3 and tags.tag_name='".$value['title']."'")->count();
            $item['lack1'] = $n*4-$item['count1'];
            $item['lack2'] = $n*4-$item['count2'];
            $item['lack3'] = $n*4-$item['count3'];
            
            $data[] = $item;
            //其它标签书籍
            $sum1 -= $item['count1'];
            $sum2 -= $item['count2'];
            $sum3 -= $item['count3'];
        }
        $other['name'] = '其它';
        $other['count1'] = $sum1;
        $other['count2'] = $sum2;
        $other['count3'] = $sum3;
        $other['lack1'] = $n*8-$other['count1'];
        $other['lack2'] = $n*8-$other['count2'];
        $other['lack3'] = $n*8-$other['count3'];
        $data[] = $other;
        $data[] = $sum;

        $xlsData = $data;

        $this->exportExcel($xlsName,$xlsCell,$xlsData);
         
    }

    function expClass(){//导出Excel
        $xlsName  = "类别统计";
       
        $xlsCell  = array(
        array('name','分类'),
        array('count1','一年级'),
        array('count2','二年级'),
        array('count3','三年级'),
        array('count4','四年级'),
        array('count5','五年级'),
        array('count6','六年级'),
        );
        $class = M('bookclass')->select();
        foreach($class as $key=>$value){
            $item['name'] = $value['typename'];
            $item['count1'] = M('books')->where("book_class='".$value['typename']."' and book_level=1")->count();
            $item['count2'] = M('books')->where("book_class='".$value['typename']."' and book_level=2")->count();
            $item['count3'] = M('books')->where("book_class='".$value['typename']."' and book_level=3")->count();
            $item['count4'] = M('books')->where("book_class='".$value['typename']."' and book_level=4")->count();
            $item['count5'] = M('books')->where("book_class='".$value['typename']."' and book_level=5")->count();
            $item['count6'] = M('books')->where("book_class='".$value['typename']."' and book_level=6")->count();
            $xlsData[] = $item;
        }

        $this->exportExcel($xlsName,$xlsCell,$xlsData);
         
    }

    public function exportExcel($expTitle,$expCellName,$expTableData){
        $xlsTitle = iconv('utf-8', 'gb2312', $expTitle);//文件名称
        $fileName =$xlsTitle.date('_YmdHis');//or $xlsTitle 文件名称可根据自己情况设定
        $cellNum = count($expCellName);
        $dataNum = count($expTableData);
        vendor("PHPExcel.PHPExcel");
       
        $objPHPExcel = new PHPExcel();
        $cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
        
        //$objPHPExcel->getActiveSheet(0)->mergeCells('A1:'.$cellName[$cellNum-1].'1');//合并单元格
       // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle.'  Export time:'.date('Y-m-d H:i:s'));  
        for($i=0;$i<$cellNum;$i++){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].'1', $expCellName[$i][1]); 
        } 
          // Miscellaneous glyphs, UTF-8   
        for($i=0;$i<$dataNum;$i++){
          for($j=0;$j<$cellNum;$j++){
            $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+2), $expTableData[$i][$expCellName[$j][0]]);
          }             
        }  
        
        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xls"');
        header("Content-Disposition:attachment;filename=$fileName.xls");//attachment新窗口打印inline本窗口打印
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
        $objWriter->save('php://output'); 
        exit;   
    }
    
    
    
    

}
?>