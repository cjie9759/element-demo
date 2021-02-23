<?php
$pathinfo = explode('/', $_SERVER['PATH_INFO']);
$s1 = $pathinfo[1] ?? 'upl';
$s2 = $pathinfo[2] ?? 'index';
// $post = json_decode($_POST['json']) ?? $_POST;

// $s1 = $pathinfo[1] ?? 'api';
define('SafeS', ['api', 'login', 'loginout', 'upl', 'req']);
in_array($s1, SafeS) || exit('erro request');

$demo = new $s1;
echo $demo->$s2();
exit();
// exit('right');

/* 
*    index
*    	index
*    	query
*    	upload
*    	\commit
*    api
*        \getdata
*        login
*        logincheck 
*    base
*        islogin
*        getMsg
*        setMsg
*/

class api extends base
{
    function getdata()
    {
        $a = $this->getMsg();
        $b = explode(PHP_EOL, $a['links']);
        shuffle($b);
        $a['link'] = end($b);
        echo json_encode($a);
        // echo json_encode($a);
    }
    function login()
    {
        //  防止全局变量造成安全隐患
        $admin = false;
        //  启动会话，这步必不可少
        session_start();
        //  判断是否登陆
        if (isset($_SESSION["admin"]) && $_SESSION["admin"] === true) {
            echo <<<EOL
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> <html xmlns="http://www.w3.org/1999/xhtml"> <head> <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" /> <title>跳转提示</title> <style type="text/css"> * { padding: 0; margin: 0; } body { background: #fff; font-family: "Microsoft Yahei", "Helvetica Neue", Helvetica, Arial, sans-serif; color: #333; font-size: 16px; } .system-message { padding: 24px 48px; } .system-message h1 { font-size: 100px; font-weight: normal; line-height: 120px; margin-bottom: 12px; } .system-message .jump { padding-top: 10px; } .system-message .jump a { color: #333; } .system-message .success, .system-message .error { line-height: 1.8em; font-size: 36px; } .system-message .detail { font-size: 12px; line-height: 20px; margin-top: 12px; display: none; } </style> </head> <body> <div class="system-message"> <h1>:(</h1> <p class="error">您已登录，请勿重复登录</p> <p class="detail"></p> <p class="jump"> 页面自动 <a id="href" href="/index/index">跳转</a> 等待时间： <b id="wait">3</b> </p> </div> <script type="text/javascript"> (function() { var wait = document.getElementById('wait'), href = document.getElementById('href').href; var interval = setInterval(function() { var time = --wait.innerHTML; if (time <= 0) { location.href = href; clearInterval(interval); }; }, 1000); })(); </script> </body> </html>
 EOL;
        } else {
            echo <<<'EOL'
            <!DOCTYPE HTML> <html> <head> <meta charset="utf-8"> <meta name="renderer" content="webkit|ie-comp|ie-stand"> <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" /> <meta http-equiv="Cache-Control" content="no-siteapp" /> <title>直播后台管理系统</title> </head> <body> <input type="hidden" id="TenantId" name="TenantId" value="" /> <div class="header"> <h2 style="margin: 1% 5%;padding:0px;color: white;"><b>直播后台管理系统</b></h2> </div> <div class="loginWraper"> <div id="loginform" class="loginBox"> <form class="form form-horizontal" action="index.html" method="post"> <div class="row cl"> <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60d;</i></label> <div class="formControls col-xs-8"> <input id="user" name="user" type="text" placeholder="用户名" class="input-text size-L" value=""> </div> </div> <div class="row cl"> <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60e;</i></label> <div class="formControls col-xs-8"> <input id="pwd" name="pwd" type="password" placeholder="密码" class="input-text size-L"> </div> </div> <div class="row cl"> <div class="formControls col-xs-8 col-xs-offset-3"> <input id="login" type="button" class="btn btn-success radius size-L" value="&nbsp;登&nbsp;&nbsp;&nbsp;&nbsp;录&nbsp;"> </div> </div> </form> </div> </div> <div class="footer">&#169;大学生网络信息中心</div> <script type="text/javascript" src="/jquery.min.js"></script> <!--ajax提交--> <script> $(function() { $('#login').on('click', function() { $.ajax({ type: 'POST', url: "/api/logincheck", data: $('form').serialize(), dataType: 'json', success: function(data) { if (data.status == 1) { alert(data.message); window.location.href = "/index/index"; } else { alert(data.message); } } }); }) }) </script> </body> </html>
 EOL;
        }
    }
    function logincheck()
    {
        $user = 'cjie';
        $pwd = 'admin.cjie';
        $post = $_POST;
        $rUser = $post['user'];
        $rPwd = $post['pwd'];
        $status = 0;
        $message = '密码错误';
        if ($user === $rUser && $pwd === $rPwd) {
            $status = 1;
            $message = '登录成功，点击确认进入后台';
            session_set_cookie_params(24 * 3600);
            session_start();
            $_SESSION['admin'] = true;
        }
        $data = ['status' => $status, 'message' => $message];
        echo json_encode($data);
    }
}
class base
{
    function getMsg()
    {
    }
    function connectDemo($value = '')
    {
        // include '../private/dbconfig.php';
        $dbms = 'mysql';     //数据库类型
        $host = 'localhost'; //数据库主机名
        $port = '3306';    //端口
        $dbName = 'zhibo';    //使用的数据库
        $user = 'root';      //数据库连接用户名
        $pass = 'gH6&fB2|bG0%aC0!cO8#cB7#lA0#oG';          //对应的密码
        $dsn = "$dbms:host=$host;port=$port;dbname=$dbName";

        try {
            $dbh = new PDO($dsn, $user, $pass); //初始化一个PDO对象
        } catch (PDOException $e) {
            die("Error!: " . $e->getMessage() . "<br/>");
        }
        //默认这个不是长连接，如果需要数据库长连接，需要最后加一个参数：array(PDO::ATTR_PERSISTENT => true) 变成这样：
        // $dbh = new PDO($dsn, $user, $pass);
        return $dbh;
    }
    function getMesDemo($value = '')
    {
        $a['erro'] = 1;
        $conn = $this->connect();
        try {
            $sql = "SELECT * FROM `index` WHERE `id`=1";
            $a = $conn->query($sql)->fetch();
            $a['erro'] = 0;
            return $a;
        } catch (PDOException $e) {
            $a['erro'] = 1;
            return $a;
        }
        $conn = null;
    }
    function islogin()
    {
        //  防止全局变量造成安全隐患
        $admin = false;
        //  启动会话，这步必不可少
        session_start();
        //  判断是否登陆
        if (!isset($_SESSION["admin"]) || $_SESSION["admin"] !== true) {
            $_SESSION["admin"] = false;
            session_destroy();
            echo <<<EOL
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> <html xmlns="http://www.w3.org/1999/xhtml"> <head> <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" /> <title>跳转提示</title> <style type="text/css"> * { padding: 0; margin: 0; } body { background: #fff; font-family: "Microsoft Yahei", "Helvetica Neue", Helvetica, Arial, sans-serif; color: #333; font-size: 16px; } .system-message { padding: 24px 48px; } .system-message h1 { font-size: 100px; font-weight: normal; line-height: 120px; margin-bottom: 12px; } .system-message .jump { padding-top: 10px; } .system-message .jump a { color: #333; } .system-message .success, .system-message .error { line-height: 1.8em; font-size: 36px; } .system-message .detail { font-size: 12px; line-height: 20px; margin-top: 12px; display: none; } </style> </head> <body> <div class="system-message"> <h1>:(</h1> <p class="error">用户未登陆,无权访问</p> <p class="detail"></p> <p class="jump"> 页面自动 <a id="href" href="/api/login">跳转</a> 等待时间： <b id="wait">3</b> </p> </div> <script type="text/javascript"> (function() { var wait = document.getElementById('wait'), href = document.getElementById('href').href; var interval = setInterval(function() { var time = --wait.innerHTML; if (time <= 0) { location.href = href; clearInterval(interval); }; }, 1000); })(); </script> </body> </html>
EOL;
        }
    }
}
class index extends base
{
    function __construct()
    {
        $this->islogin();
    }
    function index()
    {
        echo <<<'EOL'
             <!DOCTYPE html> <html lang="en"> <head> <meta charset="UTF-8"> <meta http-equiv="X-UA-Compatible" content="IE=edge"> <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- cdn --> <!-- <script src="htt\ps://unpkg.com/vue@next"></script> --> <!-- <link rel="stylesheet" href="https://unpkg.com/element-plus/lib/theme-chalk/index.css"> --> <!-- <script src="https://unpkg.com/element-plus/lib/index.full.js"></script> --> <!-- <script src="https://cdn.staticfile.org/axios/0.18.0/axios.min.js"></script> --> <!-- <script src="https://unpkg.com/axios/dist/axios.min.js"></script> --> <script src="/axios.min.js"></script> <script src="/vue.js"></script> <link rel="stylesheet" href="/ele.css"> <script src="/ele.js"></script> <title>Document</title> <style type="text/css"> body, html { padding: 0; margin: 0; /* background: url('./bac.jpg'); */ /* background-repeat: no-repeat; */ /* background-size: 100% auto; */ /* background-color: #F2F6FC; */ } #app { margin: auto; max-width: 960px; /* background-color: #EBEEF5; */ border-left: 1px solid #F2F6FC; border-right: 1px solid #F2F6FC; } </style> </head> <body> <div id="app"> <el-container style="height: 100vh;"> <el-header style="background-color :null;border-bottom:1px solid #DCDFE6;padding: 0 40px;"> <bl-header :data="headerData">head</bl-header> </el-header> <el-container style="height: 80vh;"> <el-aside width="200px " style="overflow-x: hidden;padding-left:20px;"> <el-scrollbar> <bl-aside @hash-chang="changHash" :items="menuItems">aside</bl-aside> </el-scrollbar> </el-aside> <el-container style="border-left: 1px solid #DCDFE6;"> <el-main> <el-scrollbar> <el-page-header @back="goBack" :content="menuItems[hash].title" style="padding-bottom: 100px;"> </el-page-header> <keep-alive> <component :is="mainComponent" :data="mainData" style="padding-right: 20px;">null</component> </keep-alive> </el-scrollbar> </el-main> <el-footer height="auto" style="background-color: transparent; border-top: 1px solid #DCDFE6;"> <bl-footer :data="footerData">footer</bl-footer> </el-footer> </el-container> </el-container> </el-container> </div> <script> const BlAside = { template: ` <el-menu :uniqueOpened="false" :default-active="hash" class="el-menu-vertical-demo" @open="handleOpen" @close="handleClose" @select="select" background-color="transparent" text-color="" active-text-color="" style="height: 100%;"> <el-menu-item v-for="(item, index) in items" :index="String(index)" :disabled="item.disabled"> <i :class="item.ico"></i> <template #title>{{item.title}}</template> </el-menu-item> </el-menu>`, inject: ['hash'], props: ['items'], methods: { handleOpen(key, keyPath) {}, handleClose(key, keyPath) {}, select(key, keyPath) { location.hash = key; this.$emit('hash-chang', key); }, }, }; const BlHeader = { template: ` <el-row type="flex" justify="space-between" align="middle" style="height: 100%; "><el-link type="primary" :underline="false"><span style="font-size: 24px;"><b>{{data.logo}}</b></span></el-link> <el-dropdown @command="handleCommand"> <span class="el-dropdown-link" style="font-size: 20px;"> {{data.username}} <i class="el-icon-arrow-down el-icon--right"></i> </span> <template #dropdown> <el-dropdown-menu> <el-dropdown-item v-for="(item, index) in data.items" :command="item.command" :disabled="item.disabled">{{item.title}}</el-dropdown-item> </el-dropdown-menu> </template></el-dropdown> </el-row>`, props: ['data'], methods: { handleCommand(command) { this.$message('click on item ' + command); } }, }; const BlFooter = { template: ` <el-row type="flex" justify="center" align="bottom"> <el-link type="info" :underline="false"> <p>{{data.p}}</p> </el-link> </el-row> `, props: ['data'] }; const MainTest = { template: ` <h1>{{data}}</h1> `, props: ['data'], data() { return { form: { name: '', region: '', date1: '', date2: '', delivery: false, type: [], resource: '', desc: '' } } }, }; const BlUploadDemo = { template: ` <el-upload class="upload-demo" ref="upload" :action="uploadurl" :on-preview="handlePreview" :on-remove="handleRemove" :on-exceed="exceed" :on-error="error" :on-success="success" :file-list="fileList" :limit="Number(1)" list-type="picture"> <el-button size="small" type="primary">点击上传</el-button> <template #tip> <div class="el-upload__tip"> 只能上传 jpg/png 文件，且不超过 500kb </div> </template> </el-upload> `, props: ['uploadurl', 'name'], emits: ['set-value'], data() { return { fileList: [] }; }, methods: { handleRemove(file, fileList) { var a = { name: this.name, url: null }; this.$emit('set-value', a); }, handlePreview(file) { this.$message('click on item ,but nothing to show'); }, exceed() { this.$message.warning('已达上限'); }, success(response, file, fileList) { if (response.erro == 0) { var a = { name: this.name, url: response.url }; this.$emit('set-value', a); this.$message.success(response.msg); } else { this.$refs.upload.clearFiles(); this.$message.error(response.msg); } }, error() { this.$message.warning('上传失败'); } } }; const BlFormDemo = { template: ` <el-form ref="form1" :model="form" label-width="100px"> <el-form-item :label="item.label" v-for="(item,index) in items"> <el-input v-model="form[item.name]" :type="item.type" v-if="item.type == 'text' ||item.type == 'textarea'" style="max-width:90vh"></el-input> <el-switch v-model="form[item.name]" active-color="#13ce66" inactive-color="#ff4949" v-if="item.type == 'switch'"> </el-switch> <el-color-picker v-model="form[item.name]" v-if="item.type=='color'"></el-color-picker> </el-form-item> <el-form-item> <el-button type="primary" @click="onSubmit">立即创建</el-button> <!-- <el-button>取消</el-button> --> </el-form-item> </el-form> `, data() { var data = { form: {}, items: [{ name: 'text', type: 'text', label: 'text', }, { name: 'textarea', type: 'textarea', label: 'textarea', }, { name: 'color', type: 'color', label: 'color', }, { name: 'switch', type: 'switch', label: 'switch', }] }; for (const key in data.items) { data.form[data.items[key].name] = 'dafalut' + key; } return data; }, methods: { onSubmit() {} }, }; const BlFormFrant = { template: ` <el-form ref="form1" :model="form" label-width="100px"> <el-form-item :label="item.label" v-for="(item,index) in items"> <el-input v-model="form[item.name]" :type="item.type" v-if="item.type == 'text' ||item.type == 'textarea'" style="max-width:90vh"></el-input> <el-switch v-model="form[item.name]" active-color="#13ce66" inactive-color="#ff4949" v-if="item.type =='switch'"> </el-switch> <el-color-picker v-model="form[item.name]" v-if="item.type=='color'"></el-color-picker> <bl-upload :uploadurl="action" :name="item.name" @set-value="setValue" v-if="item.type=='upload'"></bl-upload> </el-form-item> <el-form-item> <el-button type="primary" @click="onSubmit">立即创建</el-button> <!-- <el-button>取消</el-button> --></el-form-item> </el-form> `, data() { var data = { form: {}, action: '/test.php/upl', items: [{ name: 'title', type: 'text', label: '页面标题', }, { name: 'links', type: 'textarea', label: '推流链接', }, { name: 'logo', type: 'upload', label: 'logo图', }, { name: 'bac', type: 'upload', label: '背景图', }, { name: 'sortitle', type: 'text', label: '会序标题', }, { name: 'sortlist', type: 'textarea', label: '会序列表', }, { name: 'theme', type: 'color', label: '主题色', }, { name: 'fontcolor', type: 'color', label: '字体色', }] }; axios.get('/test.php/req/res').then(function(response) { data.form = response.data.data; }).catch(function(error) {}); return data; }, methods: { onSubmit() { axios({ url: '/test.php/req', method: 'post', headers: { 'Content-Type': 'application/x-www-form-urlencoded' }, data: 'json=' + JSON.stringify(this.form) }).then(function(response) { response.erro == 0 && this.$message.success(response.msg); }).catch(function(error) {}); }, setValue(data) { this.form[data.name] = data.url; } }, components: { 'bl-upload': BlUploadDemo, } }; const App = { data() { return { hash: location.hash.substr(1, 2) || "2", menuItems: [{ disabled: true, ico: "el-icon-menu", title: "用户管理", }, { disabled: true, ico: "el-icon-menu", title: "站点状态", }, { disabled: false, ico: "el-icon-menu", title: "前台配置", }], headerData: { logo: '直播后台', username: 'test', items: [{ disabled: true, title: "修改密码", command: "command1" }, { disabled: true, title: "退出", command: "command2" }] }, footerData: { p: 'power by cjie' }, mainData: {} }; }, components: { 'bl-aside': BlAside, 'bl-header': BlHeader, 'bl-footer': BlFooter, 'bl-form': BlFormDemo, 'bl-upload': BlUploadDemo, 'main-0': MainTest, 'main-1': BlUploadDemo, 'main-2': BlFormFrant, }, provide: { hash: location.hash.substr(1, 2) || "2", }, computed: { mainComponent() { return 'main-' + this.hash; }, username() { return 'test'; } }, methods: { goBack() {}, changHash(hash, title) { this.hash = hash; } }, }; const app = Vue.createApp(App); app.use(ElementPlus); app.mount("#app"); </script> </body> </html>   
EOL;
    }
    function query()
    {
        header('Content-Type:application/json');
        $data = json_decode($this->getMsg());
        $msg = "right";
        $erro = 0;
        $a = [
            'erro' => $erro,
            'msg' => $msg,
            'data' => $data
        ];
        echo json_encode($a);
    }
    function commit()
    {
        header('Content-Type:application/json');
        $data = json_decode($_POST('json')) ?? null;
        // $data = json_decode($this->getMsg());
        $msg = "提交成功";
        $erro = 0;
        $a = [
            'erro' => $erro,
            'msg' => $msg,
            'data' => $data
        ];
        echo json_encode($a);
    }
    function upload()
    {
        $allowedExts = array("gif", "jpeg", "jpg", "png");
        $temp = explode(".", $_FILES["file"]["name"]);
        $extension = end($temp);        // 获取文件后缀名

        $data['msg'] = '上传失败';
        $data['erro'] = 1;
        header('Content-Type:application/json');
        if ((($_FILES["file"]["type"] == "image/gif")
                || ($_FILES["file"]["type"] == "image/jpeg")
                || ($_FILES["file"]["type"] == "image/jpg")
                || ($_FILES["file"]["type"] == "image/pjpeg")
                || ($_FILES["file"]["type"] == "image/x-png")
                || ($_FILES["file"]["type"] == "image/png"))
            && ($_FILES["file"]["size"] < 204800 * 25)    // 小于 200 kb
            && in_array($extension, $allowedExts)
        ) {
            if ($_FILES["file"]["error"] > 0) {
                $data['msg'] = "错误：: " . $_FILES["file"]["error"] . "<br>";
            } else {
                // echo "上传文件名: " . $_FILES["file"]["name"] . "<br>";
                // echo "文件类型: " . $_FILES["file"]["type"] . "<br>";
                // echo "文件大小: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
                // echo "文件临时存储的位置: " . $_FILES["file"]["tmp_name"];
                if (!file_exists('./upload/')) {
                    mkdir('./upload/', 0777, true);
                }
                $save_path = "./upload/" . date("Ymd") . md5(md5($_FILES["file"]["name"]) . random_bytes(10)) . '.' . $extension;
                $a = move_uploaded_file($_FILES["file"]["tmp_name"], $save_path);
                if ($a) {
                    $data['erro'] = 0;
                    $data['msg'] = '上传成功';
                    $data['url'] = $save_path;
                }
                // echo "文件存储在: " .$save_path;
            }
        } else {
            $data['msg'] = "非法的文件格式";
        }
        echo json_encode($data);
    }
}
