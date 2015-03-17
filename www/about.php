<html>
  <head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="css/easy.css" type="text/css"/>
  </head>
  <body>
<?php include ('header.php');?>
    <div  class="middle_fixed_div" style="">
    <h1 style="text-align:center">手持打印机系统使用帮助</h1>

<p style="font-family:recharge-bd;font-size:20;text-align:center">
使用手册
</p>
<textarea style="border-radius: 5px" rows="20" cols="85">
1、开机进入首页界面：显示的图像为上次打印／预览成功的图像，点击下面的打印按钮能重新打印；
2、点击导航中的“文件列表”按钮，进入文件列表界面：文件列表界面中显示的是系统中已经存在的可打印配置文件，选中其中一个文件名前面的“复选框”（同时选取多个，默认处理第一个；若不选则会弹出提醒框），然后则能进行下面按钮对应的操作：
	a)新建按钮：进入新建页面，进行新建打印配置文件的建立；
	b)编辑按钮：进入编辑页面，对选中的打印配置文件进行编辑，编辑规则：
		　i):编辑页面首先呈现简略可视化样式，用户可以通过切换键选中某个对象，点击则能进入到该对象的具体编辑页面；
		 ii):针对改对象的类型进行类型、大小、格式等的设置；
		 iii):设置内容完成之后，点击下方的提交按钮则编辑成功，成功后页面自动跳转到简略可视化页面。
	c):删除按钮：删除选中的可打印配置文件；
	d):预览：进行可打印配置文件的预览结果页面；
	e):打印：将选中的可打印配置文件进行预览显示并进行打印处理。
3、点击导航中的“系统设置”按钮，进入到系统配置列表页面，页面中的打印相关项能进行手动编辑，否则则为默认，内容编辑完成之后，点击“提交”按钮。点击下方的“屏幕校准”按钮则能进行屏幕校准，校准规则为：
	a):点击“屏幕校准”按钮，进行校准界面；
	b):逐次点击出现的“[＋]”按钮，点击完成之后等待10S左右的时间，系统会进入到首页；
        c):校准完成，屏幕可进行触屏操作。
4、点击导航中的“关于”按钮，进行到用户使用手册页面。	
</textarea>

<p style="font-family:recharge-bd;font-size:20;text-align:center">
键盘按键使用注意事项
</p>
<textarea style="border-radius: 5px" rows="27" cols="85">
键值表：
[↑]:上箭头
[↓]:下箭头
[←]:左箭头
[→]:右箭头
[O]:按钮点击键/确定键
[-]:快捷键（能快速地在导航和下面的div之间切换）
[X]:返回/删除键
[TAB]:切换键
[CAPS]:大小写切换键
[123]:数字模式键
[中/En]:中英输入法切换键
[0~9]:九宫格键盘键
[#/@]:标点符号/特殊符号键
[↙]:回车键/导航点击键

1、使用数字输入模式，先点击[123]按钮，然后才可进行数字输入；
2、使用标点符号模式：先点击[#/@]按钮，然后才可进行标点符号输入；
3、中文打字规则：
	a):首先点击[中/En]键，使系统进入到中文输入法模式；
	b):然后点击[0~9]各个按钮，按照传统的九宫格输入法确定要输入的字母；
	c):通过[←]、[→]两个键来选中要输入的字；
	d):点击[↑]键使完成的文字进入到输入文本框中。
4、按钮点击规则：
	a):在导航中进行切换时，点击[↙]键进行相应的界面；
	b):在各个页面中，触发按钮请点击[O]键。	
</textarea>

<p style="font-family:recharge-bd;font-size:20;text-align:center">
打印配置文件数据字段注意事项
</p>
<textarea style="border-radius: 5px" rows="70" cols="85">
公共字段
-------
必选 index 整数
必选 type   text［text ｜ counter | time | ]
必选 x  >0
必选 y  [0, 128]
必选 content 文本
可选 font: [simkai | ]
可选 fontsize: [20, 100]

1、文本（text）

	"index": "8",
	"type": "text",
	"x": "100",
	"y": "100",
	"font": "arial",
	"fontsize": "20",
	"content": "电子工业出版社"
2. 计数器（counter）
必选 updown 递增 
必选 step	1
－必选 cycle 0
	"index": "9",
	"type": "counter",
	"x": "100",
	"y": "122",
	"updown": "up",
	"fontsize": "20",
	"content": "1",
	"step": "1",
	"cycle": "0"
3. 时间（time）
必选 tformate  H:I:S［H:I:S | H:I:S AM | H时I分S秒］
			"index": "11",
			"type": "time",
			"x": "100",
			"y": "0",
			"tformate": "h:i:s",
			"fontsize": "20",
			"content": "13:32:43"
4. 日期（date）
必选 dformate y/m/d [y/m/d | y-m-d | y.m.d | y年m月d日 ｜ m/d/y]
			"index": "1",
			"type": "date",
			"x": "0",
			"y": "0",
			"dformate": "y/m/d",
			"fontsize": "20",
			"content": "2014/11/05"
5. 图片（picture）
注：content为文件名，默认路径是 pic／

6. 条形码（barcode）
注：content为转化内容。

7. 二维码（qrcode）
注：content为转化内容。
必选 refix 清晰度 L [L, M ,Q, H]
必选 size  尺寸 4 ［1,10]

			"index": "2",
			"type": "qrcode",
			"x": "100",
			"y": "0",
			"content": "二维码",
			"refix": "H",
			"size": "6"	
</textarea>
    </div>
</body>
</html>
