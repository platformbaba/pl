package com.sg.adserver.handlers;

import java.io.IOException;
import java.io.PrintWriter;

import javax.servlet.ServletException;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.eclipse.jetty.server.Request;
import org.eclipse.jetty.server.handler.AbstractHandler;
import org.eclipse.jetty.util.StringUtil;

import com.mongodb.BasicDBObject;
import com.mongodb.util.JSON;
import com.sg.adserver.maps.AdDataImpl;
import com.sg.adserver.maps.SpotAdData;



public class UpdateHandler extends AbstractHandler{

	public void handle(String arg0, Request req, HttpServletRequest arg2,
			HttpServletResponse resp) throws IOException, ServletException {

		PrintWriter pwriter = resp.getWriter();
		try{
		String ad_data = req.getParameter("ad");
		String spot_ad_data = req.getParameter("spot_ad");
		String counts = new String("{}");
		if(!StringUtil.isBlank(ad_data)){
			BasicDBObject ad_data_obj = (BasicDBObject) JSON.parse(ad_data);
			counts = AdDataImpl.updateAdData(ad_data_obj);
		}
		if(! StringUtil.isBlank(spot_ad_data)){
			BasicDBObject ad_spot_data_obj = (BasicDBObject) JSON.parse(spot_ad_data);
			SpotAdData.updateAdData(ad_spot_data_obj);
		}
		
		pwriter.write(counts);
		
		}catch(Exception e ){
			e.printStackTrace();
		}finally{
			pwriter.close();	
		}
	}

}
