package com.sg.adserver.maps;

import com.mongodb.BasicDBObject;


public class AdDataImpl {

	private static volatile BasicDBObject ad_map = new BasicDBObject();
	private static BasicDBObject counters  = new BasicDBObject();

	public static String getCounts(){
		// TODO reset the counts
		// jsonify counter array
		
		return null;
	}
	
	public static String updateAdData(BasicDBObject obj){
		String _c =new String();
		if(obj!=null){
			ad_map = obj;
		}
		if(counters!=null){
			 _c = counters.toString();
		}
		return _c;
	}
	
	public static synchronized void incrementClick(Integer ad_id,Integer spot_id){
		
		BasicDBObject c = (BasicDBObject) counters.get(ad_id+"_"+spot_id);
		if(c==null){
			c= new BasicDBObject();
			c.put("c", 0);
			c.put("i", 0);
			counters.put(ad_id+"_"+spot_id, c);
		}
		c.put("c", c.getInt("c")+1);
	}
	
	public static String getAd(String ad_id,Integer spot_id,boolean js){
	
		BasicDBObject ad = (BasicDBObject) ad_map.get(ad_id);
		String adString = js?ad.getString("js"):ad.getString("nojs");
		if(adString!=null){
			synchronized (AdDataImpl.class) {
				BasicDBObject c = (BasicDBObject) counters.get(ad_id+"_"+spot_id);
				if(c==null){
					c= new BasicDBObject();
					c.put("c", 0);
					c.put("i", 0);
					counters.put(ad_id+"_"+spot_id, c);
				}
				c.put("i", c.getInt("i")+1);
			}
			return adString;
		}
		return "0";
	}

	public static String getAdOnclick(Integer spotId, Integer adId) {
		BasicDBObject ad = (BasicDBObject) ad_map.get(adId);
		String onclick = new String();
		if(ad!=null){
			onclick  = ad.getString("onclick");
			incrementClick(adId, spotId);
		}
		return onclick;
	}

	
}