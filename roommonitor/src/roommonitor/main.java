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
		// ����һ���ַ��������洢��ҳ����
		String result = "";
		
		// ����һ�������ַ�������
		BufferedReader in = null;
		
		try{
			// ��stringת��url����
			URL realUrl = new URL(url);
			// ��ʼ��һ�����ӵ��Ǹ�url������
			URLConnection connection = realUrl.openConnection();
			// ��ʼʵ�ʵ�����
			connection.connect();
			// ��ʼ�� BufferedReader����������ȡURL����Ӧ
			in = new BufferedReader(new InputStreamReader(connection.getInputStream()));
			// ������ʱ�洢ץȡ����ÿһ�е�����
			String line;
			while ((line = in.readLine()) != null) {
				// ����ץȡ����ÿһ�в�����洢��result����
				result += line;
			}
		} catch(Exception e){
			System.out.println("����GET��������쳣��" + e);
			e.printStackTrace();
		}
		
		// ʹ��finally���ر�������
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
		// ����һ����ʽģ�壬����ʹ��������ʽ����������Ҫץ������
		// �൱�����������ƥ��ĵط��ͻ����ȥ
		Pattern pattern = Pattern.compile(patternStr);
		
		// ����һ��matcher������ƥ��
		Matcher matcher = pattern.matcher(targetStr);
		
		// ����ҵ���
		if (matcher.find()) {
		// ��ӡ�����
			return matcher.group(1);
		}
		return "Nothing";
	}
	
	public static void main(String[] args) {
		// TODO Auto-generated method stub
		// ���弴�����ʵ�����
		String url = "http://marknad.karlskronahem.se/ledigt/studentlagenhet";

		// �������Ӳ���ȡҳ������
		String result = sendget(url);
		// ʹ������ƥ��ͼƬ��src����
		String roomtag1 = RegexString(result, "<table.*?>([\\s\\S]*)</table>");
		String roomtag2 = RegexString(result, "<table.*?>([\\s\\S]*)</table>");
		
		while(true){
			try {
				result = sendget(url);
				roomtag2 = RegexString(result, "<table.*?>([\\s\\S]*)</table>");
				
				if(roomtag1.compareTo(roomtag2)==0){//Ҫ��conpareTo���бȽϣ�==����ֻ�ܵ����ַ������ֵıȽϣ������ַ�����������
					roomtag1=roomtag2;
					System.out.println("Same");
					Thread.sleep(5000);
				}
				else{
					//System.out.println(roomtag1);
					//System.out.println(roomtag2);
					//��Ƶ����
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
		// �������Ӳ���ȡҳ������
		String result = sendget(url);
		// ʹ������ƥ��ͼƬ��src����
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
					
					//��Ƶ����
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
