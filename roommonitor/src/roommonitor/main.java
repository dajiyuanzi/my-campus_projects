package roommonitor;

import java.applet.Applet;
import java.applet.AudioClip;
import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.net.URL;
import java.net.URLConnection;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

public class main {

	public static String sendget(String url){
		// 定义一个字符串用来存储网页内容
		String result = "";
		
		// 定义一个缓冲字符输入流
		BufferedReader in = null;
		
		try{
			// 将string转成url对象
			URL realUrl = new URL(url);
			// 初始化一个链接到那个url的连接
			URLConnection connection = realUrl.openConnection();
			// 开始实际的连接
			connection.connect();
			// 初始化 BufferedReader输入流来读取URL的响应
			in = new BufferedReader(new InputStreamReader(connection.getInputStream()));
			// 用来临时存储抓取到的每一行的数据
			String line;
			while ((line = in.readLine()) != null) {
				// 遍历抓取到的每一行并将其存储到result里面
				result += line;
			}
		} catch(Exception e){
			System.out.println("发送GET请求出现异常！" + e);
			e.printStackTrace();
		}
		
		// 使用finally来关闭输入流
		finally{
			try{
				if(in!=null){
					in.close();
				}
			}catch(Exception e2){
				e2.printStackTrace();
			}
		}
		return result;
	}
	
	static String RegexString(String targetStr, String patternStr){
		// 定义一个样式模板，此中使用正则表达式，括号中是要抓的内容
		// 相当于埋好了陷阱匹配的地方就会掉下去
		Pattern pattern = Pattern.compile(patternStr);
		
		// 定义一个matcher用来做匹配
		Matcher matcher = pattern.matcher(targetStr);
		
		// 如果找到了
		if (matcher.find()) {
		// 打印出结果
			return matcher.group(1);
		}
		return "Nothing";
	}
	
	public static void main(String[] args) {
		// TODO Auto-generated method stub
		// 定义即将访问的链接
		String url = "http://marknad.karlskronahem.se/ledigt/studentlagenhet";

		// 访问链接并获取页面内容
		String result = sendget(url);
		// 使用正则匹配图片的src内容
		String roomtag1 = RegexString(result, "<table.*?>([\\s\\S]*)</table>");
		String roomtag2 = RegexString(result, "<table.*?>([\\s\\S]*)</table>");
		
		while(true){
			try {
				result = sendget(url);
				roomtag2 = RegexString(result, "<table.*?>([\\s\\S]*)</table>");
				
				if(roomtag1.compareTo(roomtag2)==0){//要用conpareTo进行比较，==不行只能单个字符或数字的比较，可能字符串里有杂质
					roomtag1=roomtag2;
					System.out.println("Same");
					Thread.sleep(5000);
				}
				else{
					//System.out.println(roomtag1);
					//System.out.println(roomtag2);
					//音频播放
					try{
					      AudioClip ac = Applet.newAudioClip(new URL("file:./src/roommonitor/audio.wav" ));
					      ac.play();
					      //ac.stop();
					} catch (Exception e) {
					      System.out.println(e);
					}
					
					roomtag1=roomtag2;
					System.out.println("different");
					Thread.sleep(5000);
				}
				
			} catch (InterruptedException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
		}
	}

}

/* Test on localhost website Superkarlskrona
		String url = "http://localhost/Team31/frontend/";
		// 访问链接并获取页面内容
		String result = sendget(url);
		// 使用正则匹配图片的src内容
		String roomtag1 = RegexString(result, "<div class=\"span9\">([\\s\\S]*)</div>");
		String roomtag2 = RegexString(result, "<div class=\"span9\">([\\s\\S]*)</div>");
		
		while(true){
			try {
				result = sendget(url);
				roomtag2 = RegexString(result, "<div class=\"span9\">([\\s\\S]*)</div>");
				
				if(roomtag1.compareTo(roomtag2)==0){
					roomtag1=roomtag2;
					System.out.println("Same");
					Thread.sleep(5000);
				}
				else{
					System.out.println(roomtag1);
					System.out.println(roomtag2);
					roomtag1=roomtag2;
					System.out.println("different");
					
					//音频播放
					try{
					      AudioClip ac = Applet.newAudioClip(new URL("file:./src/roommonitor/audio.wav" ));
					      ac.play();
					      //ac.stop();
					} catch (Exception e) {
					      System.out.println(e);
					} 
					
					Thread.sleep(5000);
				}
				
			} catch (InterruptedException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
		}

*/
