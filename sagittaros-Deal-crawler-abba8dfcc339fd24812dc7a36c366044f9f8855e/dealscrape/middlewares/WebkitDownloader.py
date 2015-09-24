from scrapy.http import Request, FormRequest, HtmlResponse

import gtk
import webkit
import jswebkit
import re

class WebkitDownloader( object ):

    def process_request( self, request, spider ):
        print '--------------------'

        print spider.allowlist
        isDealPage = True
        for i in spider.allowlist:
            if not re.findall(i,request.url):
                isDealPage = False
        
        print '--------------------'
        #process the response with webkit
        if( isDealPage and type(request) is not FormRequest ):
            webview = webkit.WebView()
            webview.connect( 'load-finished', lambda v,f: gtk.main_quit() )
            webview.load_uri( request.url )
            settings = webview.get_settings()
            settings.set_property('auto-load-images', False)
            gtk.main()
            js = jswebkit.JSContext( webview.get_main_frame().get_global_context() )
            renderedBody = str( js.EvaluateScript( 'document.documentElement.innerHTML' ) )
            return HtmlResponse( request.url, body=renderedBody )

        
        