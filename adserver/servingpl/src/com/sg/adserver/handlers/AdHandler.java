package com.sg.adserver.handlers;
import java.io.IOException;
import java.io.PrintWriter;

import javax.servlet.ServletException;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.eclipse.jetty.server.Request;
import org.eclipse.jetty.server.handler.AbstractHandler;
import org.eclipse.jetty.util.StringUtil;

import com.sg.adserver.maps.SpotAdData;

public class AdHandler extends AbstractHandler {

	public void handle(String arg0, Request req, HttpServletRequest arg2,
			HttpServletResponse resp) throws IOException, ServletException {
		
		PrintWriter respWriter = resp.getWriter();
		try{
			Integer spotId=0;
			Double lat =null;
			Double lng =null;
			Boolean isFlash = true;
			Boolean isJs = true;
			String ip = null;
		
			if(!StringUtil.isBlank(req.getParameter("sid"))){
				spotId = Integer.parseInt(req.getParameter("sid"));
				lat = !StringUtil.isBlank(req.getParameter("lat"))?
						Double.parseDouble(req.getParameter("lat")):null;
				lng = !StringUtil.isBlank(req.getParameter("lng"))?
						Double.parseDouble(req.getParameter("lng")):null;
				isFlash = !StringUtil.isBlank(req.getParameter("isFlash")) && req.getParameter("isFlash").equals("0")?
						false:true;
				isJs = !StringUtil.isBlank(req.getParameter("isJs")) && req.getParameter("isJs").equals("0")?
						false:true;
				ip = req.getRemoteAddr();
				
			}else{
				throw new Exception();
			}
		
			String city = new String();
			String state = new String();
			String country = new String();
			String res = SpotAdData.getNextAd(spotId,new Double[]{lat,lng},isFlash,isJs,city,state,country);
			
			respWriter.print(res);
		}catch(Throwable t){
				
			respWriter.print("0");
		}finally{
		
			respWriter.close();
		}
	}

}


