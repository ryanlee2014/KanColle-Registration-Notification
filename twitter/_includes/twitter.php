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
	$twitter_data = json_decode($json, true);	// Create an array with the fetched JSON data
############################################################### 	
	## DO SOMETHING WITH THE DATA
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
	echo '<ul id="tweet-list" class="tweet-list" style="width:95%;margin:auto;margin-top:1em;">';
	}
	$CountNum=0;
	$Count_Num=0;
	$maintenancetweet="";
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
		# The tweet
		$id = number_format($tweet['id'],0,'','');
		$formattedTweet = !$isRetweet ? formatTweet($tweet['text']) : formatTweet($retweet['text']);
		if($_GET['get']=="tweet")
		{
		$formattedTweet = str_replace("艦これ","舰队collection",$formattedTweet);
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
$url=$userAvatarURL;
$filename="avatar.png"; 
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
					echo '<a class="link-details permalink-status" data-role="button" data-inline="true" href="' . $statusURL . '" target="_blank">查看详细内容</a></p>';
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
}
$nextd=preg_match("/(?:、)【[\s\S]*?\/[\s\S]*?】(?=以降)/",$formattedTweet,$nextdate);
if($nextd==1&&$Count_Num==0)
{
	$next_text=$nextdate[0];
	$next_text=str_replace("、","",$next_text);
	$Count_Num++;
}
	if(preg_match("/【[\s\S]+?/[\s\S]+?】[\s\S]+?メンテナンス/",$formattedTweet,$mainten)==1&&$maintenancetweet!="")
	{
		$maintenancetweet=$formattedTweet;
	}	
	else
	{
		$maintenancetweet+="ts";	
	}
	$CountNum++;
	}	# End tweets loop
	$endCode=preg_match("/終了/",$firstTweet,$isEnd);
	/*if($maintenancetweet!="")
	{
		if($_GET['maintenance']=="1")
		{
			header('Content-Type:application/x-javascript;charset=utf-8');
			echo $maintenancetweet;
		}	
	}*/
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
	# Close the timeline list
	if($_GET['e']=="")
	{
	echo '</ul>';
	}
	# echo $json; // Uncomment this line to view the entire JSON array. Helpful: http://www.freeformatter.com/json-formatter.html
?>