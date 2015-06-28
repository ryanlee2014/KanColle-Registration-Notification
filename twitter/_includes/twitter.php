<?php
/**
 * twitter-timeline-php : Twitter API 1.1 user timeline implemented with PHP, a little JavaScript, and web intents
 * 
 * @package		twitter-timeline-php
 * @author		Kim Maida <contact@kim-maida.com>,Ryan<gxlhybh@gmail.com>
 * @license		http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link		http://github.com/kmaida/twitter-timeline-php
 * @credits		Thank you to <http://viralpatel.net/blogs/twitter-like-n-min-sec-ago-timestamp-in-php-mysql/> for base for "time ago" calculations 
 *
**/
############################################################### 
	## SETTINGS
	// Set access tokens <https://dev.twitter.com/apps/>
	$settings = array(
		'consumer_key' => "v5e3riajAmkSmll4ImBDkijef",
		'consumer_secret' => "Cy9mhGbRvQtA10iMCFMVB4F0z4uZxujeWsiVC1ZaeVtYItP6u7",
		'oauth_access_token' => "495804727-bO06fUX0qO7S5ARYW5w9fDOoQddgRE2awbPuCcLr",
		'oauth_access_token_secret' => "U65VEcL3AprmUWDjgFXwzKlHNCjYR2y28Lq46ZBy39wVS"
	);
	// Set API request URL and timeline variables if needed <https://dev.twitter.com/docs/api/1.1>
	$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
	$twitterUsername = "KanColle_STAFF";
	$tweetCount = $_GET['t'];
	if($tweetCount=="")
	{
		$tweetCount=20;	
	}
	// Use private tokens for development if they exist; delete when no longer necessary
	$tokens = '_utils/tokens.php';
	is_file($tokens) AND include $tokens;
	// Require the OAuth class
	require_once('_utils/twitter-api-oauth.php');
###############################################################
	## MAKE GET REQUEST
	$getfield = '?screen_name=' . $twitterUsername . '&count=' . $tweetCount;
	$twitter = new TwitterAPITimeline($settings);
	$json = $twitter->setGetfield($getfield)	// Note: Set the GET field BEFORE calling buildOauth()
				  	->buildOauth($url, $requestMethod)
				 	->performRequest();
	$json_cache = $json;
	$json_decode = json_decode($json,true);
	$twitter_data = json_decode($json, true);	// Create an array with the fetched JSON data
############################################################### 	
	## DO SOMETHING WITH THE DATA
	##
	function pic_save($url,$filename)
{
if($url=="") return false; 
if($filename=="") { 
$ext=strrchr($url,"."); 
if($ext!=".gif" && $ext!=".jpg" && $ext!=".png") return false; 
$filename=date("YmdHis").$ext; 
} 
ob_start(); 
readfile($url); 
$img = ob_get_contents(); 
ob_end_clean(); 
$size = strlen($img); 
$fp2=@fopen($filename, "w"); 
fwrite($fp2,$img); 
fclose($fp2); 
}
	##
//-------------------------------------------------------------- Format the time(ago) and date of each tweet
	function timeAgo($dateStr) {
		$timestamp = strtotime($dateStr);	 
		$day = 60 * 60 * 24;
		$today = time(); // current unix time
		$since = $today - $timestamp;
		 # If it's been less than 1 day since the tweet was posted, figure out how long ago in seconds/minutes/hours
		 if (($since / $day) < 1) {
		 	$timeUnits = array(
				   array(60 * 60, '小时'),
				   array(60, '分'),
				   array(1, '秒')
			  );
			  for ($i = 0, $n = count($timeUnits); $i < $n; $i++) { 
				   $seconds = $timeUnits[$i][0];
				   $unit = $timeUnits[$i][1];
				   if (($count = floor($since / $seconds)) != 0) {
					   break;
				   }
			  }
			  return "$count{$unit}前";
		# If it's been a day or more, return the date: day (without leading 0) and 3-letter month
		 } else {
			  return date('j M', strtotime($dateStr));
		 }	 
	}
//-------------------------------------------------------------- Format the tweet text (links, hashtags, mentions)
	function formatTweet($tweet) {
		$linkified = '@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@';
		$hashified = '/(^|[\n\s])#([^\s"\t\n\r<:]*)/is';
		$mentionified = '/(^|[\n\s])@([^\s"\t\n\r<:]*)/is';
		$prettyTweet = preg_replace(
			array(
				$linkified,
				$hashified,
				$mentionified
			), 
			array(
				'<a href="$1" class="link-tweet" target="_blank">$1</a>',
				'$1<a class="link-hashtag" href="https://twitter.com/search?q=%23$2&src=hash" target="_blank">#$2</a>',
				'$1<a class="link-mention" href="http://twitter.com/$2" target="_blank">@$2</a>'
			), 
			$tweet
		);
		return $prettyTweet;
	}
//-------------------------------------------------------------- Timeline HTML output
	# This output markup adheres to the Twitter developer display requirements (https://dev.twitter.com/terms/display-requirements)
	# Open the timeline list
	if($_GET['e']=="")
	{
	echo '<ul id="tweet-list" class="tweet-list" style="width:95%;margin:auto;margin-top:1em;　border-radius: 15px;">';
	}
	$CountNum=0;
	$maintenance_flag=0;
	$full_time_count=0;
	$part_time_count=0;
	$event_count=0;
	$maintenancetweet="";
	$maintenance_part_tweet="";
	$maintenance_part_count=0;
	$nextcount=0;
	$nexttweet="";
	# The tweets loop
	foreach ($twitter_data as $tweet) {
		$retweet = $tweet['retweeted_status'];
		$isRetweet = !empty($retweet);
		# Retweet - get the retweeter's name and screen name
		$retweetingUser = $isRetweet ? $tweet['user']['name'] : null;
		$retweetingUserScreenName = $isRetweet ? $tweet['user']['screen_name'] : null;
		# Tweet source user (could be a retweeted user and not the owner of the timeline)
		$user = !$isRetweet ? $tweet['user'] : $retweet['user'];	
		$userName = $user['name'];
		$userScreenName = $user['screen_name'];
		$userAvatarURL = stripcslashes($user['profile_image_url']);
		$userAccountURL = 'http://twitter.com/' . $userScreenName;		
		# Twitter Background
		$userBackground = $tweet['user']['profile_background_image_url'];
		# The tweet
		$id = number_format($tweet['id'],0,'','');
		$formattedTweet = !$isRetweet ? formatTweet($tweet['text']) : formatTweet($retweet['text']);
		if($_GET['get']=="tweet")
		{
		$formattedTweet = str_replace("艦これ","舰队collection",$formattedTweet);
		$formattedTweet = str_replace("各既存サーバ群の整備/強化を目的とした", "为了整备/强化各游戏服务器", $formattedTweet);
		$formattedTweet = str_replace("サーバメンテナンスを実施させて頂く予定です", "进行服务器维护", $formattedTweet);
		$formattedTweet = str_replace("実施日時が決まりましたら、別途お知らせ致します。", "决定时间另行通知", $formattedTweet);
		$formattedTweet = str_replace("・ブラウザのキャッシュを削除 ・お使いのブラウザを変更 ・PC時間設定の確認 もぜひお試しください。どうぞよろしくお願い致します！", "请检查浏览器缓存是否清除、更换浏览器、确定计算机时间与服务器时间（日本时区）一致。", $formattedTweet);
		$formattedTweet = str_replace("新規着任ご希望の方は、「艦これ」にご接続ください。何度か試しても着任できない場合は", "希望上任的新任提督请打开游戏页面，若多次尝试均无法就任", $formattedTweet);
		$formattedTweet = str_replace("サーバ","服务器",$formattedTweet);
		$formattedTweet = str_replace("「艦娘」たちの世界へようこそ…","欢迎来到舰娘们的世界。",$formattedTweet);
		$formattedTweet = str_replace("ブラウザ","浏览器",$formattedTweet);
		$formattedTweet = str_replace("皆さんの着任を歓迎致します","欢迎各位提督的到任",$formattedTweet);
		$formattedTweet = str_replace("次回","下次",$formattedTweet);
		$formattedTweet = str_replace("開放は","开放是",$formattedTweet);
		$formattedTweet = str_replace("おはようございます","早上好",$formattedTweet);
		$formattedTweet = str_replace("キャッシュを削除","消除缓存",$formattedTweet);
		$formattedTweet = str_replace("メンテナンス","维护",$formattedTweet);
		$formattedTweet = str_replace("スタート","开始",$formattedTweet);
		$formattedTweet = str_replace("新たな提督の着任を受け入れ中","正在接受新提督的着任",$formattedTweet);
		$formattedTweet = str_replace("アップデート","升级",$formattedTweet);
		$formattedTweet = str_replace("マル","〇",$formattedTweet);
		$formattedTweet = str_replace("キュー","九",$formattedTweet);
		$formattedTweet = str_replace("サン","三",$formattedTweet);
		$formattedTweet = str_replace("オリジナルサウンドトラック","Original SoundTrack",$formattedTweet);
		$formattedTweet = str_replace("バージョン","version",$formattedTweet);
		$formattedTweet = str_replace("フルサイズ","Full Size",$formattedTweet);
		$formattedTweet = str_replace("イラスト","插画",$formattedTweet);
		$formattedTweet = str_replace("ソロモン","所罗门",$formattedTweet);
		$formattedTweet = str_replace("提督の皆さん","各位提督",$formattedTweet);
		$formattedTweet = str_replace("ヒト","一",$formattedTweet);
		$formattedTweet = str_replace("ヨン","四",$formattedTweet);
		$formattedTweet = str_replace("に伴う","伴随的",$formattedTweet);
		$formattedTweet = str_replace("】より","【左右",$formattedTweet);
		$formattedTweet = str_replace("受け入れる","接受",$formattedTweet);
		$formattedTweet = str_replace("今日は","今天是",$formattedTweet);
		$formattedTweet = str_replace("午後から","下午开始",$formattedTweet);
		$formattedTweet = str_replace("水曜日","星期三",$formattedTweet);
		$formattedTweet = str_replace("月曜日","星期一",$formattedTweet);
		$formattedTweet = str_replace("日曜日","星期日",$formattedTweet);
		$formattedTweet = str_replace("火曜日","星期二",$formattedTweet);
		$formattedTweet = str_replace("木曜日","星期四",$formattedTweet);
		$formattedTweet = str_replace("金曜日","星期五",$formattedTweet);
		$formattedTweet = str_replace("土曜日","星期六",$formattedTweet);
		$formattedTweet = str_replace("ブック","Book",$formattedTweet);
		$formattedTweet = str_replace("カバー","Cover",$formattedTweet);
		$formattedTweet = str_replace("アクセス","连接数",$formattedTweet);
		$formattedTweet = str_replace("皆さんの着任を心より歓迎致します", "我们从心底欢迎提督们的到来", $formattedTweet);
		$formattedTweet = str_replace("レベル","等级",$formattedTweet);
		$formattedTweet = str_replace("お手数をお掛けして恐縮です、ご協力どうぞよろしくお願い致します。","为您带来不必要的麻烦，请见谅。",$formattedTweet);
		$formattedTweet = str_replace("ファイル","文件",$formattedTweet);
		$formattedTweet = str_replace("インターネット","Internet访问",$formattedTweet);
		$formattedTweet = str_replace("キャッシュ","缓存",$formattedTweet);
		$formattedTweet = str_replace("ご協力","您的配合",$formattedTweet);
		$formattedTweet = str_replace("ありがとうございました","非常感谢",$formattedTweet);
		$formattedTweet = str_replace("まるで","就像是",$formattedTweet);
		$formattedTweet = str_replace("のような","一样",$formattedTweet);
		$formattedTweet = str_replace("本日も頑張ってまいりましょう！","今天也请加油！",$formattedTweet);
		$formattedTweet = str_replace("大変お待たせ致しました！","久等了！",$formattedTweet);
		$formattedTweet = str_replace(" メンテ明け","维护结束",$formattedTweet);
		$formattedTweet = str_replace("体調管理にも気をつけて","也请注意自己的身体",$formattedTweet);
		}
		$statusURL = 'http://twitter.com/' . $userScreenName . '/status/' . $id;
		$date = timeAgo($tweet['created_at']);
		# Reply
		$replyID = number_format($tweet['in_reply_to_status_id'],0,'','');
		$isReply = !empty($replyID);
		# Tweet actions (uses web intents)
		$replyURL = 'https://twitter.com/intent/tweet?in_reply_to=' . strval($id);
		$retweetURL = 'https://twitter.com/intent/retweet?tweet_id=' . strval($id);
		$favoriteURL = 'https://twitter.com/intent/favorite?tweet_id=' . strval($id);	
?>
<?php
# Avatar Server Cache
if($CountNum==1)
{
pic_save($userAvatarURL,"avatar.png");
pic_save($userBackground,"background.png");	
}
if((!$_GET['e']=="end")||($_GET['test']=="1")){
?>			
		<li style="font-family:微软雅黑,黑体;text-align:left;" id="<?php echo 'tweetid-' . $id; ?>" class="tweet<?php 
				if ($isRetweet) echo ' is-retweet'; 
				if ($isReply) echo ' is-reply'; 
				if ($tweet['retweeted']) echo ' visitor-retweeted';
				if ($tweet['favorited']) echo ' visitor-favorited'; ?>">
			<div class="tweet-info">
				<div class="user-info">
					<a class="user-avatar-link" href="<?php echo $userAccountURL; ?>">
						<img class="user-avatar" src="../twitter/avatar.png">
					</a>
					<p class="user-account">
						<a class="user-name" href="<?php echo $userAccountURL; ?>"><strong><?php echo $userName; ?></strong></a>
						<a class="user-screenName" href="<?php echo $userAccountURL; ?>">@<?php echo $userScreenName; ?></a>
					</p>
				</div>
				<a class="tweet-date permalink-status" href="<?php echo $statusURL; ?>" target="_blank">
					<?php echo $date; ?>
				</a>
			</div>
			<blockquote class="tweet-text">
				<?php 	
					echo '<p>' . $formattedTweet . '</p>'; 
					echo '<p class="tweet-details">';
					if ($isReply) {
						echo '
							<a target="_blank" data-role="button" data-inline="true" class="link-reply-to permalink-status" href="http://twitter.com/' . $tweet['in_reply_to_screen_name'] . '/status/' . $replyID . '">
								回复于...
							</a>
						';
					}
					if ($isRetweet) {
						echo '
							<span class="retweeter">
								转推于 <a target="_blank" data-role="button" data-inline="true" class="link-retweeter" href="http://twitter.com/' . $retweetingUserScreenName . '">' .
								$retweetingUser
								. '</a>
							</span>
						';
					}
					echo '<a class="link-details permalink-status" data-role="button" style="z-index:999" data-inline="true" href="' . $statusURL . '" target="_blank">查看详细内容</a></p>';
				?>		
			</blockquote>
			<div class="tweet-actions">
				<a data-role="button" style="width:3.5em;" data-inline="true" class="action-reply" target="_blank" href="<?php echo strval($replyURL); ?>">回复</a>
				<a data-role="button" style="width:3.5em;" data-inline="true" class="action-retweet" target="_blank" href="<?php echo strval($retweetURL); ?>">转推</a>
				<a data-role="button" style="width:3.5em;" data-inline="true" class="action-favorite" target="_blank" href="<?php echo strval($favoriteURL); ?>">收藏</a>
			</div>
		</li>	
<?php }
if($CountNum==0)
{
$firstTweet=$formattedTweet;	
$background_url = $userBackground;
}
if($nextcount==0)
{
	$next_flag=preg_match("/サーバ開放、全着任枠【終了】/", $formattedTweet,$next_flag_txt);
	if($next_flag==1)
	{
		$nexttweet=$formattedTweet;
		$nextcount++;
	}
}
$nextd=preg_match("/【\d*?\/[\s\S]*?】/",$formattedTweet,$nextdate);
$mainten=preg_match("/メンテナンス/",$formattedTweet,$maintenance_text);
$mainten_s_flag=preg_match("/開始時間は/",$formattedTweet,$mainten_s_flag_text);
$mainten_intxt_flag=preg_match("/【[\s\S]+?\/[\s\S]+?】/",$formattedTweet,$mainten_text_flag);
$netim=preg_match("/\d+\/\d+\([\x80-\xff]*(曜)*日\)\s*\d+:\d+(\s*)(?=】)/",$formattedTweet,$full_time_text);
$ntp=preg_match("/：【\d+\/\d+\(\S+\)(\S*)\】/",$formattedTweet,$nowtimepart);
$evti=preg_match("/イベント[\s\S]+?曜日\)/",$contents,$event_time);
if($maintenance_part_count==0)
{
	$maintenance_part_flag=preg_match("/【[\s\S]+?\/[\s\S]+?】/", $formattedTweet,$maintenance_part);
	if($maintenance_part_flag==1&&$mainten==1)
	{
		$maintenance_part_tweet=$formattedTweet;
	}
}
if($evti==1&&$event_count==0)
{
	$event_text=$event_time[0];	
}
if($ntp==1&&$part_time_count==0)
{
	$part_time_value=$nowtimepart[0];
	preg_match("/約[\s\S]+?名/",$formattedTweet,$part_people);
	$part_people_number=str_replace("約","",$part_people[0]);
	$part_people_number=str_replace("名","",$part_people_number);
	$part_time_value=str_replace("：","",$part_time_value);
	$part_time_value=str_replace("【","",$part_time_value);
	$part_time_value=str_replace("】","",$part_time_value);
	$part_time_count++;	
}
if($netim==1&&$full_time_count==0)
{
	$full_time_value=$full_time_text[0];
	preg_match("/約[\s\S]+?名/",$formattedTweet,$full_people);
	$full_people_number=str_replace("約","",$full_people[0]);
	$full_people_number=str_replace("名","",$full_people_number);
	$full_time_count++;
}
if($mainten==1&&$mainten_s_flag==1&&$maintenance_flag==0&&$mainten_intxt_flag==1)
{
	$maintenancetweet=$formattedTweet;
	$maintenance_flag++;	
}
	$CountNum++;
	}	# End tweets loop
	$first_flag=preg_match("/終了/", $firstTweet,$isEnd);
	$maintenance_part_inflag=preg_match("/【[\s\S]+?\/[\s\S]+?】/",$maintenance_part_tweet,$maintenance_part_txt);
	$maintenance_part_text=$maintenance_part_txt[0];
$event_name_flag=preg_match("/期間限定海域【[\s\S]+?】/",$event_text,$event_name);
$event_name_value=str_replace("期間限定海域","",$event_name[0]);
$event_name_value=str_replace("【","",$event_name_value);
$event_name_value=str_replace("】","",$event_name_value);
$event_month_flag=preg_match("/\d{1,2}(?=\/)/",$event_text,$event_month);
$event_month_value=$event_month[0];
$event_date_flag=preg_match("/\d{1,2}(?=\()/",$event_text,$event_date);
$event_date_value=$event_date[0];
$event_weekday_flag=preg_match("/[\x80-\xff]{1,9}(曜)*日/",$event_text,$event_weekday);
$event_weekday_value=$event_weekday[0];
$mainten_divide=preg_match("/【[\s\S]+?\/[\s\S]+?】/",$maintenancetweet,$mainten_time);
$mainten_month_flag=preg_match("/\d{1,2}/",$mainten_time[0],$mainten_m);
$mainten_date_flag=preg_match("/\d{1,2}(?=\()/",$mainten_time[0],$mainten_d);
$mainten_weekday_flag=preg_match("/[\x80-\xff]{1,9}(曜)*日/",$mainten_time[0],$mainten_w);
$mainten_start=preg_match("/開始時間は【[\s\S]+?】/",$maintenancetweet,$mainten_s);
$mainten_end=preg_match("/(完了は|同完了時間は)【[\s\S]+?】/",$maintenancetweet,$mainten_e);
$maintenance_s="null";
$maintenance_e="null";
$maintenance_s=str_replace("開始時間は","",$mainten_s[0]);
$maintenance_e=str_replace("完了は","",$mainten_e[0]);
$maintenance_e=str_replace("同完了時間は", "", $maintenance_e);
$maintenance_s=str_replace("【","",$maintenance_s);
$maintenance_e=str_replace("【","",$maintenance_e);
$maintenance_s=str_replace("】","",$maintenance_s);
$maintenance_e=str_replace("】","",$maintenance_e);
$maintenance_time=str_replace("】","",$mainten_time[0]);
$maintenance_time=str_replace("【","",$maintenance_time);
if($next_flag==1)
{
	preg_match("/【\d+?\/[\s\S]+?】/", $nexttweet,$next_txt);
	$next_text=$next_txt[0];
	$next_text=str_replace("、","",$next_text);
	$next_text=str_replace("明","",$next_text);
	$next_text=str_replace("後","",$next_text);
	$next_text=str_replace("日【","",$next_text);
	$next_text=str_replace("【","",$next_text);
	$next_text=str_replace("】","",$next_text);
}
if($maintenance_time=="")
{
	$maintenance_time=$maintenance_part_text;
}
if($maintenance_s=="")
{
	$maintenance_s="null";	
}
if($maintenance_e=="")
{
	$maintenance_e="null";	
}
		if($_GET['e']=="end")
		{
			header('Content-Type:application/x-javascript;charset=utf-8');
			if($isEnd[0]=="終了")
			{
			echo "end=true;";	
			}
			else
			{
			echo "end=false;";
			}
		}
		if($_GET['e']=="next")
		{
			header('Content-Type:application/x-javascript;charset=utf-8');
			echo $next_text;	
		}
		if($_GET['e']=="maintenance")
		{
			header('Content-Type:application/x-javascript;charset=utf-8');
			echo "mainten=".$mainten_time[0]."end\n";
			echo "start_time=".$maintenance_s."end\n";
			echo "stop_time=".$maintenance_e."end\n";
			echo $maintenancetweet."\n";
		}
		if($_GET['e']=="full")
		{
			header('Content-Type:application/x-javascript;charset=utf-8');
			echo $full_time_value;	
		}
		if($_GET['e']=="part")
		{
			header('Content-Type:application/x-javascript;charset=utf-8');
			echo $part_time_value;
		}
		if($_GET['e']=="api")
		{
			header('Content-Type:application/x-javascript;charset=utf-8');
			echo "full_time".$full_time_value." full_people_num".$full_people_number."end_people"."full_time_end\n";
			echo "part_time".$part_time_value." part_people_num".$part_people_number."end_people"."part_time_end\n";
			echo "next_time".$next_text."next_time_end\n";
			echo "mainten_time".$maintenance_time."mainten_time_end\n";
			echo "start_time=".$maintenance_s."start_time_end\n";
			echo "stop_time=".$maintenance_e."stop_time_end\n";
			echo "event_name".$event_name_value."event_name_end\n";
			echo "event_month".$event_month_value."event_month_end\n";
			echo "event_date".$event_date_value."event_date_end\n";
			echo "event_weekday".$event_weekday_value."event_weekday_end";	
		}
		if($_GET['e']=="json")
		{
			header('Content-Type:application/json;charset=utf-8');
			echo $json_cache;	
		}
		if($_GET['e']=="jsondecode")
		{
			header('Content-Type:application/json;charset=utf-8');
			echo $json_decode;	
		}
		if($_GET['e']=="background")
		{
			echo "<img src=\"$background_url\"></img>";
		}
	# Close the timeline list
	if($_GET['e']=="")
	{
	echo '</ul>';
	}
	# echo $json; // Uncomment this line to view the entire JSON array. Helpful: http://www.freeformatter.com/json-formatter.html
?>