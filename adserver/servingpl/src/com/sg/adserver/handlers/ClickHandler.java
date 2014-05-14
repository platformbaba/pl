package com.sg.adserver.handlers;

import java.io.IOException;
import java.io.PrintWriter;

import javax.servlet.ServletException;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.eclipse.jetty.server.Request;
import org.eclipse.jetty.server.handler.AbstractHandler;
import org.eclipse.jetty.util.StringUtil;

import com.sg.adserver.maps.AdDataImpl;


public class ClickHandler extends AbstractHandler{

	@Override
	public void handle(String arg0, Request arg1, HttpServletRequest req,
			HttpServletResponse resp) throws IOException, ServletException {

		PrintWriter out = resp.getWriter();
		try{
			Integer spotId= 0;
			Integer adId = 0;
			String token = null;
			
			if(!StringUtil.isBlank(req.getParameter("sid"))
					&&
						!StringUtil.isBlank(req.getParameter("aid"))
					&&
						!StringUtil.isBlank(req.getParameter("token"))	
				){
				
				spotId = Integer.parseInt(req.getParameter("sid"));
				
				adId = Integer.parseInt(req.getParameter("aid"));
				
				token = req.getParameter("token");
				if(!isTokenValid(token)){
					throw new Exception();
				}
				String onclik = AdDataImpl.getAdOnclick(spotId, adId);
				resp.sendRedirect(onclik);
			}else{
				throw new Exception();
			}
		}catch(Throwable t){
				
			out.print("0");
		}finally{
		
			out.close();
		}
			
	}

	private boolean isTokenValid(String token) {
		// TODO Auto-generated method stub
		return true;
	}

}
