package com.sg.adserver.server;

import java.io.File;
import java.io.IOException;

import javax.servlet.ServletException;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.eclipse.jetty.server.Handler;
import org.eclipse.jetty.server.Request;
import org.eclipse.jetty.server.Server;
import org.eclipse.jetty.server.handler.AbstractHandler;
import org.eclipse.jetty.server.handler.ContextHandler;
import org.eclipse.jetty.server.handler.ContextHandlerCollection;
import org.eclipse.jetty.util.thread.QueuedThreadPool;

import com.maxmind.geoip.LookupService;
import com.sg.adserver.handlers.AdHandler;
import com.sg.adserver.handlers.ClickHandler;
import com.sg.adserver.handlers.UpdateHandler;


public class AdServer extends AbstractHandler {
	
	
	public static final int MAX_THREAD_POOL_SIZE = 10;
	public static LookupService ls =null;
	{
		try{
			ls = new LookupService(new File("C:\\Users\\admin\\workspace\\adserver\\geodata\\GeoIP.dat"));
			
		}catch(Exception e){
			
		}
	}
	/*public static void main(String[] args) throws Exception {
	
	
		Server server = new Server(8888);
		server.setHandler(new AdServer());
		server.start();
		server.join();
	}*/
	

	@Override
	public void handle(String arg0, Request arg1, HttpServletRequest arg2,
			HttpServletResponse arg3) throws IOException, ServletException {
			System.out.println("it works");
	}
	
	
	public static void main(String[] args) throws Exception {
	
		
		Server server = new Server(8010);
		ContextHandler adcontext = new ContextHandler();
        adcontext.setContextPath("/getad");
        adcontext.setResourceBase(".");
        adcontext.setClassLoader(Thread.currentThread().getContextClassLoader());
        adcontext.setHandler(new AdHandler());
        
        ContextHandler upcontext = new ContextHandler();
        upcontext.setContextPath("/upad");
        upcontext.setClassLoader(Thread.currentThread().getContextClassLoader());
        upcontext.setHandler(new UpdateHandler());
        
        ContextHandler clickcontext = new ContextHandler();
        clickcontext.setContextPath("/counts");
        clickcontext.setClassLoader(Thread.currentThread().getContextClassLoader());
        clickcontext.setHandler(new ClickHandler());
        
      //context.setHandler(new HelloHandler());
        ContextHandlerCollection contexts = new ContextHandlerCollection();
        contexts.setHandlers(new Handler[]{adcontext,upcontext,clickcontext});
        server.setHandler(contexts);
   
        
        server.start();
        server.join();
	}

	
}
