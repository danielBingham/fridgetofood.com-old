<?php
/*
 * Copyright:
 *		Copyright (C) 2009-2011 Daniel Bingham (http://www.theroadgoeson.com)
 *
 * License:
 *
 * This software is licensed under the MIT Open Source License which reads as
 * follows:
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in the
 * Software without restriction, including without limitation the rights to use, copy,
 * modify, merge, publish, distribute, sublicense, and/or sell copies of the Software,
 * and to permit persons to whom the Software is furnished to do so, subject to the
 * following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies
 * or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,
 * INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR
 * PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
 * TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE
 * USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 * For more information see here: http://www.opensource.org/licenses/mit-license.php
 */


class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

	/**
	 * Bootstrap the configuration into the registry where we can
	 * access it from anywhere in the application.
	 */
	public function _initConfig() {
			$config = new Zend_Config_Ini(APPLICATION_PATH 
							. DIRECTORY_SEPARATOR . 'configs'
							. DIRECTORY_SEPARATOR . 'application.ini', APPLICATION_ENV );
			Zend_Registry::set('config', $config);
	}
	

    public function _initRoutes() {
        $front = Zend_Controller_Front::getInstance();
        $router = $front->getRouter();

        // {{{ recipe:      recipe/:id/:url_title

        $route = new Zend_Controller_Router_Route(
                        'recipe/:id/:url_title',
                        array(
                            'controller'=>'recipe',
                            'action'=>'view'
                        )
                    );
        $router->addRoute('recipe', $route);

        // }}}
        // {{{ profile:     profile/:id

        $route = new Zend_Controller_Router_Route(
                        'profile/:id',
                        array(
                            'controller'=>'user',
                            'action'=>'profile'
                        )
                    );
        $router->addRoute('profile', $route);

        // }}}
        // {{{ foodies:     foodies
        
        $route = new Zend_Controller_Router_Route(
                        'foodies',
                        array(
                            'controller'=>'user',
                            'action'=>'index'
                        )
                    );
        $router->addRoute('foodies', $route);
 
        // }}} 
        // {{{ images:      images
        
        $route = new Zend_Controller_Router_Route(
                        'images',
                        array(
                            'controller'=>'photo',
                            'action'=>'index'
                        )
                    );
        $router->addRoute('images', $route);
 
        // }}} 
        // {{{ gallery:      gallery/:id 
        
        $route = new Zend_Controller_Router_Route(
                        'gallery/:id',
                        array(
                            'controller'=>'photo',
                            'action'=>'gallery'
                        )
                    );
        $router->addRoute('gallery', $route);
 
        // }}} 
        // {{{ photograph:  photograph/:id

        $route = new Zend_Controller_Router_Route(
                        'photograph/:id',
                        array(
                            'controller'=>'photo',
                            'action'=>'view'
                        )
                    );
        $router->addRoute('photograph', $route);

        // }}}
        // {{{ tags:        tags/:type

        $route = new Zend_Controller_Router_Route(
                        'tags/:type',
                        array(
                            'controller'=>'tags',
                            'action'=>'index'
                        )
                );
        $router->addRoute('tags', $route);

        // }}}
        // {{{ tagsOld:     tags/index/:type

        $route = new Zend_Controller_Router_Route(
                        'tags/index/:type',
                        array(
                            'controller'=>'tags',
                            'action'=>'index'
                        )
                );
        $router->addRoute('tagsOld', $route);

        // }}}
        // {{{ tag:         tags/view/:id
 
        $route = new Zend_Controller_Router_Route(
                        'tags/view/:id',
                        array(
                            'controller'=>'tags',
                            'action'=>'view'
                        )
                );
        $router->addRoute('tag', $route);
        
        // }}}
        // {{{ about:       about

        $route = new Zend_Controller_Router_Route(
                        '/about',
                        array(
                            'controller'=>'static',
                            'action'=>'about'
                        )
                );
        $router->addRoute('about', $route);

        // }}}
        // {{{ faq:         faq

        $route = new Zend_Controller_Router_Route(
                        '/faq',
                        array(
                            'controller'=>'static',
                            'action'=>'faq'
                        )
                );
        $router->addRoute('faq', $route);
    
        // }}} 
        // {{{ tos:         tos 

        $route = new Zend_Controller_Router_Route(
                        '/tos',
                        array(
                            'controller'=>'static',
                            'action'=>'tos'
                        )
                );
        $router->addRoute('tos', $route);
    
        // }}} 
        // {{{ privacy:         privacy 

        $route = new Zend_Controller_Router_Route(
                        '/privacy',
                        array(
                            'controller'=>'static',
                            'action'=>'privacy'
                        )
                );
        $router->addRoute('privacy', $route);
    
        // }}} 
        
    }

}

