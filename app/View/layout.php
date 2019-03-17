<?php
$lang = \Base\I18n::getCurrentLang();
$listLangs = \Base\I18n::getListLangs();
$current_moeda = isset($_COOKIE['moeda']) ? $_COOKIE['moeda'] : 'USD';

$current_url = function($lang) {
    return "https://" . $_SERVER['HTTP_HOST'] . '/' . $lang . $this->base . '/';
};

$canonicalLink = $current_url($lang);

$urlDefault = "https://" . $_SERVER['HTTP_HOST'] .'/en/' .$this->base . '/';
$version = '2.1';
?>
<!doctype html>
<html lang="<?= $lang; ?>"> 
    <head>
        <?php
        if (isset($_title)) {
            $_title = trim($_title);
            echo '<title>' . $_title . ' | CoinGoLive</title>';
        } elseif (isset($_title2)) {
            $_title = 'CoinGoLive - ' . trim($_title2);
            echo '<title>' . $_title . '</title>';
        } else {
            $_title = "CoinGoLive";
            echo '<title>CoinGoLive</title>';
        }
        ?>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta property="og:title" content="<?= trim($_title) ?>" />
        <meta property="og:image" content="<?= 'http://' . $_SERVER['HTTP_HOST']; ?>/assets/img/logo_social.png?v=<?= $version ?>" />
        <?php if (isset($_meta_description)) { ?>
            <meta name="description" content="<?= _e($_meta_description) ?>" />
            <meta property="og:description" content="<?= _e($_meta_description) ?>" />
        <?php } ?>
        <meta name="maValidation" content="2f7fd73164f4cc546df97e0e0a0fe559" />
        <link rel="icon" type="image/png" href="/assets/img/logo.png?v=<?= $version ?>1" />
        <link rel="stylesheet" href="/assets/css/material-kit.css?v=<?= $version ?>">
        <link rel="stylesheet" href="/assets/css/global.css?v=<?= $version ?>20">
        <link href="/assets/css/pace.css" media="screen" rel="stylesheet" type="text/css">
        <link rel="canonical" href="<?= $canonicalLink ?>" />
        <?php
        foreach ($_css as $c) {
            echo '<link rel="stylesheet" href="' . $c . '?v=' . $version . '">';
            echo "\n";
        }
        ?>
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="alternate" href="<?= $urlDefault ?>" hreflang="x-default">        
        <?php foreach ($listLangs as $name => $desc) { ?>
            <link rel="alternate" href="<?= $current_url($name) ?>" hreflang="<?= $name ?>">
            <?php
        }

        if (!DEBUG) {
            ?>
            <script async src="https://www.googletagmanager.com/gtag/js?id=UA-114358769-1"></script>
            <script>
                window.dataLayer = window.dataLayer || [];
                function gtag() {
                    dataLayer.push(arguments);
                }
                gtag('js', new Date());

                gtag('config', 'UA-114358769-1');
            </script>
            <!--ads-->
            <script src="https://coinzillatag.com/lib/sticky.js"></script>
            <script>window.coinzilla_sticky = window.coinzilla_sticky || [];
                function czilla() {
                    coinzilla_sticky.push(arguments);
                }
                czilla('98865aa193af59e91');</script>

            <script src="https://coinzillatag.com/lib/wpnative.js"></script><script>var c_widget = czilla_widget_popup || [];var c_widget_preferences = {}; c_widget_preferences.zone = "183275ad4c9f709767"; c_widget_preferences.yMobile = "top";c_widget_preferences.x = "right"; c_widget_preferences.y = "top"; c_widget.push(c_widget_preferences);</script>

            <?php
        }
        ?>
        <script>
            var user_country = "<?= isset($_SERVER["HTTP_CF_IPCOUNTRY"]) ? $_SERVER["HTTP_CF_IPCOUNTRY"] : false ?>";
            var currentLang = '<?= $lang; ?>';
            function siteUrl(url) {
                return '/' + currentLang + url;
            }
        </script>        
    </head>
    <body style="background-color: #f7f7f9;margin-bottom: 50px">

        <nav class=" navbar navbar-expand-sm  navbar-primary bg-primary" style=" border-radius: 0px!important; background-color: #79308c!important;padding: 0px;margin-bottom: 0px!important;box-shadow: none">
            <div class="container">
                <ul class="navbar-nav mr-auto" id="nav-global-data">
                    <li class="nav-item" id="div_global_coins">
                        <span   class="nav-link" style="padding-right: 7px;padding-left: 7px;">
                            <span style="color:#ef8aff">Coins:</span>  <span id="global_coins" style="color:#eec1f5;font-weight: 600">---</span>
                        </span>
                    </li>
                    <li class="nav-item">
                        <span   class="nav-link" style="padding-right: 7px;padding-left: 7px;">
                            <span style="color:#ef8aff"><?= _e('Market Cap:') ?></span> <span  id="global_market_cap" style="color:#eec1f5;font-weight: 600">---.---.---.---</span>
                        </span>
                    </li>
                    <li class="nav-item">
                        <span   class="nav-link" style="padding-right: 7px;padding-left: 7px;">
                            <span style="color:#ef8aff">24h Vol:</span> <span id="global_volume"  style="color:#eec1f5;font-weight: 600">---.---.---.---</span>

                        </span>
                    </li>
                    <li class="nav-item">
                        <span   class="nav-link" style="padding-right: 7px;padding-left: 7px;">
                            <span style="color:#ef8aff">BTC Domi.:</span> <span  id="global_dominance_btc" style="color:#eec1f5;font-weight: 600">---.---</span>

                        </span>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto  dropdown-menu-left visible-md cg-hide-mobile" style="flex-direction: row!important;    z-index: 8000;">

                    <li class="nav-item">
                        <a class="nav-link" target="_blank" href="https://github.com/CoinGoLive/coingolive"><i class="fa fa-github"></i></a>
                    </li>
                    <li class="dropdown nav-item" id="topMoedaAtual">
                        <a href="#" class="dropdown-toggle nav-link moedaAtual" data-toggle="dropdown">
                            <?= $current_moeda ?>
                        </a>
                        <div class="dropdown-menu ">
                            <?php
                            $listCoins= \Base\I18n::getListMoeda();
                            foreach ($listCoins as $n => $char) {
                                ?>
                                <a href="javascript:changeMoeda('<?= $n ?>',function(){ location.reload(); })" class="dropdown-item">
                                    <?= $n ?>
                                </a>
                                <?php
                            }
                            ?>
                        </div>
                    </li>
                    <li class="dropdown nav-item">
                        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                            <?= str_replace('-', '_', $lang) ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right text-right">
                            <?php
                            $listLangs = \Base\I18n::getListLangs();
                            foreach ($listLangs as $name => $desc) {
                                ?>
                                <a href="<?= '/' . $name . $this->base ?>" class="dropdown-item">
                                    <?= $desc ?>
                                </a>
                                <?php
                            }
                            ?>
                        </div>
                    </li>
                    <?php if ($user = \Base\Auth::getUser()) { ?>
                        <li class="dropdown nav-item">
                            <button  type="button"  data-toggle="dropdown"class="btn btn-secondary dropdown-toggle">
                                <?= explode(' ', $user['name'])[0] ?>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right text-right">
                                <a class="dropdown-item" href="<?= siteUrl('/user/logout/') ?>"><i class="material-icons" style="font-size: 18px;margin-right: 5px">power_settings_new</i> <?= _e('Sair') ?></a>
                            </div>
                        </li>
                    <?php } else { ?>
                        <button class="btn btn-sm btn-secondary" type="button" onclick="modalLogin()">Login</button>
                    <?php } ?>
                </ul>
            </div>
        </nav>


        <nav class=" navbar-expand-sm  navbar-primary bg-primary" id="top-search-coin" style=" border-radius: 0px!important; z-index: 7000!important; background-color: #79308c!important;padding: 0px;margin-bottom: 0px!important;box-shadow: none;display: none">
            <div class="container">
                <ul class="navbar-nav ml-auto   cg-show-mobile" style="flex-direction: row!important;display: none">

                    <form class="form-inline mr-auto" style="margin-bottom: 0;padding-bottom: 10px" onsubmit=" return false;">
                        <div class="dropdown ml-auto" style="    width: 100%;">
                            <div class="form-group has-white bmd-form-group"  style="margin-top: 10px">
                                <input type="text" class="form-control go-top-search" style="width: 90%;float: left;display: block" placeholder="<?= _e('Buscar Criptomoedas') ?>">
                                <i class="material-icons" style="color: #fff;width: 10%;float: left;display: block;cursor: pointer" onclick="toggleSearch()" >close</i>
                            </div>

                            <div class="dropdown-menu"  style="margin-top: 50px">
                                <div class="opts">
                                </div>
                            </div>
                        </div>
                    </form>
                </ul>
            </div>
        </nav>

        <nav class="navbar navbar-expand-lg  navbar-primary bg-primary" style=" z-index: 6000!important;border-radius: 0px!important; ">
            <div class="container">
                <a href="<?= siteUrl('/') ?>"  style="margin-right: 10px;"><img alt="CoinGoLive Logo" title="CoinGoLive" src="/assets/img/logo8_min.png" width="150"/></a>
                <button type="button" class="cg-show-mobile" onclick="toggleSearch()"  style="display: none;margin-bottom: -8px;margin-right: -70px;cursor: pointer; background: transparent;border:0">
                    <i class="material-icons" style="color:#fff">search</i>
                </button>
                <button  type="button" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="material-icons" style="color:#fff">list</i>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a   class="nav-link" style="padding-right: 7px;padding-left: 7px;"  href="<?= siteUrl('/coin/price/') ?>"><?= _e('Calcular Preço') ?></a>
                        </li>
                        <li class="nav-item">
                            <a   class="nav-link"  style="padding-right: 7px;padding-left: 7px;"  href="<?= siteUrl('/coin/ath-price/') ?>"><?= _e('Alta Histórica') ?></a>
                        </li>
                        <li class="nav-item">
                            <a  class="nav-link"  style="padding-right: 7px;padding-left: 7px;"  href="<?= siteUrl('/coin/price-change-history/') ?>"><?= _e('Histórico Preço') ?></a>
                        </li>
                        <li class="nav-item">
                            <a   class="nav-link"  style="padding-right: 7px;padding-left: 7px;"  href="<?= siteUrl('/coin-change/binance/btc/') ?>"><?= _e('Variação Preços') ?> 24h</a>
                        </li>
                        <?php if ($lang == 'pt-br') { ?>
                            <li class="nav-item">
                                <a  class="nav-link"  style="padding-right: 7px;padding-left:7px;"  href="<?= siteUrl('/videos-criptomoedas/') ?>"><?= _e('Vídeos') ?> <span class="badge badge-success">novo</span></a>
                            </li>
                            <li class="nav-item ">
                                <a  class="nav-link"  style="padding-right: 7px;padding-left: 7px;"  target="_blank" href="https://livecoins.com.br/"><?= _e('Notícias') ?></a>
                            </li>
                        <?php } ?>
                    </ul>
                    <ul class="navbar-nav ml-auto  dropdown-menu-left" >


                        <form class="form-inline ml-auto cg-hide-mobile" onsubmit=" return false;">
                            <div class="dropdown">
                                <div class="form-group has-white bmd-form-group">
                                    <input type="text" class="form-control go-top-search" placeholder="<?= _e('Buscar criptomoeda') ?>">
                                </div>
                                <button type="buttom" class="btn btn-primary btn-raised btn-fab btn-round">
                                    <i class="material-icons">search</i>
                                </button>

                                <div class="dropdown-menu ">
                                    <div class="opts">
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!--                             <div class="dropdown go_selectbox">
                                                    <button class="btn btn-primary btn-block btn-sm dropdown-toggle go_selectbox_btn" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?= $compare_coin ?>
                                                    </button>
                                                </div>-->
                    </ul>
                    <ul class="navbar-nav ml-auto  dropdown-menu-left visible-md cg-show-mobile" style="flex-direction: row!important;display: none">

                        <li class="nav-item">
                            <a class="nav-link" target="_blank" href="https://github.com/CoinGoLive/coingolive"><i class="fa fa-github"></i></a>
                        </li>
                        <li class="dropdown nav-item">
                            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                                <?= str_replace('-', '_', $lang) ?>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right text-right">
                                <?php
                                $listLangs = \Base\I18n::getListLangs();
                                foreach ($listLangs as $name => $desc) {
                                    ?>
                                    <a href="<?= '/' . $name . $this->base ?>" class="dropdown-item">
                                        <?= $desc ?>
                                    </a>
                                    <?php
                                }
                                ?>
                            </div>
                        </li>
                        <?php if ($user = \Base\Auth::getUser()) { ?>
                            <li class="dropdown nav-item">
                                <button  type="button"  data-toggle="dropdown"class="btn btn-secondary dropdown-toggle">
                                    <?= explode(' ', $user['name'])[0] ?>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right text-right">
                                    <a class="dropdown-item" href="<?= siteUrl('/user/logout') ?>"><i class="material-icons" style="font-size: 18px;margin-right: 5px">power_settings_new</i> <?= _e('Sair') ?></a>
                                </div>
                            </li>
                        <?php } else { ?>
                            <button class="btn btn-block btn-secondary" type="button" onclick="modalLogin()">Login</button>
                        <?php } ?>
                    </ul>

                </div>
            </div>
        </div>
    </nav>
    <div style="margin:10px;max-width: 1500px;"  class="ml-auto mr-auto">
        <?php if (!DEBUG) { ?>
            <div class="text-center" style="margin-top: 5px;margin-bottom: 5px;">
                <!-- Coinzilla Banner 728x90 -->
                <script async src="https://coinzillatag.com/lib/display.js"></script>
                <div style="min-height: 90px">
                    <div class="coinzilla" data-zone="C-415245a8c26c8245e2"></div>
                </div>
                <script>
                                window.coinzilla_display = window.coinzilla_display || [];
                                var c_display_preferences = {};
                                c_display_preferences.zone = "415245a8c26c8245e2";
                                c_display_preferences.width = "728";
                                c_display_preferences.height = "90";
                                coinzilla_display.push(c_display_preferences);
                </script>
            </div>
        <?php } ?>
        <?= $this->content ?>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modalLogin" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div id="modalLoginBody">
                ...
            </div>
        </div>
    </div>

    <footer class="footer ">
        <div class="container">
            <nav class="pull-left">
                <ul>
                    <li>
                        <a href="<?= siteUrl('/contact/') ?>">
                            <?= _e('Contato'); ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?= siteUrl('/feedback/') ?>">
                            <?= _e('Feedback'); ?>
                        </a>
                    </li>
                    <li>
                        <a   href="<?= siteUrl('/partners/') ?>"><?= _e('Parceiros') ?></a>
                    </li>
                </ul>
            </nav>
            <div class="copyright pull-right">
                <a href="https://twitter.com/coingolive" target="_blank"><i class="fa fa-twitter"></i> Twitter</a> <?= _e('Acompanhe novas atualizações'); ?>.
            </div>
        </div>
    </footer>
    <?php require __DIR__ . '/inc/news.inc.php' ?>
    <!--   Core JS Files   -->
    <script src="/assets/js/core/jquery.min.js?v=<?= $version ?>"></script>
    <script src="/assets/js/core/popper.min.js?v=<?= $version ?>"></script>
    <script src="/assets/js/bootstrap-material-design.js?v=<?= $version ?>"></script>
    <script src="/assets/js/material-kit.js?v=<?= $version ?>"></script>
    <script src="/assets/js/plugins/jquery.mask.min.js?v=<?= $version ?>"></script>
    <script src="/assets/js/global.js?v=<?= $version ?>10"></script>    
    <script type="text/javascript" src="/assets/js/plugins/pace.js"></script>    
    <script src="https://hosted-sip.civic.com/js/civic.sip.min.js"></script>
    <script>
<?= $this->js ?>
    </script>
    <?php if ($lang == 'pt-br') { ?>
        <script>
            $(document).ready(function () {
                $.getJSON('/news/news.json', function (data) {

                    var key = Math.floor(Math.random() * data.length);
                    $(".news-link").hide();
                    $(".news-link").slideDown();
                    $(".news-link").text(data[key].title);
                    $(".news-link").attr('href', data[key].url);

                    setInterval(function () {
                        var key = Math.floor(Math.random() * data.length);
                        $(".news-link").text(data[key].title);
                        $(".news-link").attr('href', data[key].url);
                        $(".news-link").hide();
                        $(".news-link").slideDown();
                    }, 7000);
                })
            });

        </script>
    <?php } ?>
    <script>

// Step 2: Instantiate instance of civic.sip
        var civicSip = new civic.sip({appId: 'rJ6jQnzWm'});

// Step 3: Start scope request.
        function civicLogin() {
            civicSip.signup({style: 'popup', scopeRequest: civicSip.ScopeRequests.BASIC_SIGNUP});
        }

// Listen for data
        civicSip.on('auth-code-received', function (event) {

            // encoded JWT Token is sent to the server
            var jwtToken = event.response;

            // Your function to pass JWT token to your server

            sendAuthCode(jwtToken);
        });

// Error events.
        civicSip.on('civic-sip-error', function (error) {
            // handle error display if necessary.
            console.log('   Error type = ' + error.type);
            console.log('   Error message = ' + error.message);
        });


        function sendAuthCode(jwtToken) {
            $.post('/en/user/civic/', {token: jwtToken}, function (data) {
                var rs = JSON.parse(data);
                if (rs.success) {
<?php
//verifica se é via mobile
if (isset($_GET['uuid'])) {
    ?>
                        window.location = window.location.href.split("?")[0];
<?php } else { ?>
                        location.reload();
<?php } ?>

                }
            });
        }

//add css
        var cssId = 'cssCivic';
        if (!document.getElementById(cssId))
        {
            var head = document.getElementsByTagName('head')[0];
            var link = document.createElement('link');
            link.id = cssId;
            link.rel = 'stylesheet';
            link.type = 'text/css';
            link.href = 'https://hosted-sip.civic.com/css/civic-modal.min.css';
            link.media = 'all';
            head.appendChild(link);
        }
    </script>
</body>
</html>
