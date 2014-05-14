import java.util.Calendar;
import java.util.TimeZone;

import org.apache.commons.codec.binary.Base64;

class SGAuthToken {

	// DO NOT MODIFY THIS
	static final Long SAREGAMA_OFFSET=1390390195L;
	
	private static String getToken(String app_id,long utc_time_in_secs){
		if(app_id==null)
			return null;
		Long time = utc_time_in_secs-SAREGAMA_OFFSET;
		String lsbs = new String();
		for(int i=0;i<=4;i++)
			lsbs+=(((time & (1<<i)) >0 ) ? '1':'0');
		int s = Integer.parseInt(lsbs, 2);
		int start = s%22;
		int[] bit={start+5,start+6,start+7,start+8};
		for(int i =0;i<bit.length;i++){
			time = time ^ (1<<bit[i]);
		}
		String etime = new String(Base64.encodeBase64((time+"").getBytes()));  
		int n = app_id.length();
		String l = app_id.substring(0, n/2);
		String r = app_id.substring(n/2);
		String iauth = rev(l+etime+r);
		String final_auth = new String(Base64.encodeBase64(iauth.getBytes()));
		if(final_auth.length()%6==0)
			final_auth = rev(final_auth);
		return final_auth;
	}
	
	private static String rev(String str){
		char[] rev = str.toCharArray();
		for(int i=0,j=rev.length-1;i<rev.length/2;i++,j--){
			char t = rev[i];
			rev[i]= rev[j];
			rev[j]=t;
		}
		return new String(rev);
	}
	public static void main(String[] args) {
		// USAGE
		String app_id = "Saregama"; // app_id provided to you
		// make sure the system is in sync with UTC time else get time from time servers
		Calendar cal = Calendar.getInstance(TimeZone.getTimeZone("UTC"));
		Long utc_time_in_secs = (cal.getTimeInMillis()/1000); 
		String token = SGAuthToken.getToken(app_id,utc_time_in_secs);
		System.out.println(token);
	}
}