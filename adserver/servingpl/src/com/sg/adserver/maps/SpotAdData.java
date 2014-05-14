package com.sg.adserver.maps;

import java.util.Random;

import com.mongodb.BasicDBList;
import com.mongodb.BasicDBObject;

public class SpotAdData {

	
	// {"spotId":[{ "adId":"1212" , "flash":1 , "country":["IN","US"] , "state":{"MAH","TN"} , "city" :{"MUM","DEL"} 
	// },{},{},{}] , "":[] , "" :[]}
	private static volatile BasicDBObject staticData = new BasicDBObject();
	private static Random rand = new Random();
	
	public static void updateAdData(BasicDBObject ad_spot_data_obj){
		if(ad_spot_data_obj!=null)
			staticData = ad_spot_data_obj;
	}
	
	public static String getNextAd(Integer spot_id, Double[] latlng,boolean flash,boolean js,String city,
									String state, String country){
		
		BasicDBObject adObj = staticData;
		String ret = new String("0");
		if(adObj!=null){
			BasicDBList spotObj = (BasicDBList) adObj.get(spot_id+"");
			if(spotObj!=null){
				String ad_id = null;
				int size =spotObj.size();
				int counter = rand.nextInt(size);
				int stopAt = size;
				while(stopAt>0){
					BasicDBObject obj = (BasicDBObject) spotObj.get(counter);
					if((flash ^ obj.getInt("flash")==1)){
						if(matchCountry(city,obj.get("country")) 
								&& matchState(state,obj.get("state")) 
								&& matchCity(city,obj.get("city"))){
							ad_id = obj.getString("adId");
						}
					}
					counter++;
					if(counter>=size)
						counter=0;
					stopAt--;
				}
				
				if(ad_id!=null)
					ret = AdDataImpl.getAd(ad_id, spot_id,js);
			}
		}
		return ret;
	}
	
	private static boolean matchCity(String city, Object object) {
		BasicDBObject cityObj = (BasicDBObject)object;
		if(cityObj!=null){
			boolean inc_exc = cityObj.getBoolean("inc_exc");
			BasicDBList list = (BasicDBList) cityObj.get("city");
			if(inc_exc ^ list.contains(city))
				return true;
			else
				return false;
		}
		return true;
	}

	private static boolean matchState(String state, Object object) {
		BasicDBObject stateObj = (BasicDBObject)object;
		if(stateObj!=null){
			boolean inc_exc = stateObj.getBoolean("inc_exc");
			BasicDBList list = (BasicDBList) stateObj.get("state");
			if(inc_exc ^ list.contains(state))
				return true;
			else
				return false;
		}
		return true;
	}

	private static boolean matchCountry(String country, Object object) {
		BasicDBObject countryObj = (BasicDBObject)object;
		if(countryObj!=null){
			boolean inc_exc = countryObj.getBoolean("inc_exc");
			BasicDBList list = (BasicDBList) countryObj.get("country");
			if(inc_exc ^ list.contains(country))
				return true;
			else
				return false;
		}
		return true;
	}
}
