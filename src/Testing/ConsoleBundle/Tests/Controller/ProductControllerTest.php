<?php

namespace Testing\ConsoleBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;

class ProductControllerTest extends WebTestCase {

    public function testIndex() {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertContains('Hello World', $client->getResponse()->getContent());

        $this->assertGreaterThan(
                0, $crawler->filter('html:contains("Hello World")')->count()
        );

        $link = $crawler
                ->filter('a:contains("Greet")') // find all links with the text "Greet"
                ->eq(1) // select the second link in the list
                ->link()
        ;
// and click it
        $crawler = $client->click($link);

        $form = $crawler->selectButton('submit')->form();
// set some values
        $form['name'] = 'Lucas';
        $form['form_name[subject]'] = 'Hey there!';
// submit the form
        $crawler = $client->submit($form);

        // Assert that the response matches a given CSS selector.
        $this->assertGreaterThan(0, $crawler->filter('h1')->count());


        // Assert that there is at least one h2 tag
// with the class "subtitle"
        $this->assertGreaterThan(
                0, $crawler->filter('h2.subtitle')->count()
        );
// Assert that there are exactly 4 h2 tags on the page
        $this->assertCount(4, $crawler->filter('h2'));
// Assert that the "Content-Type" header is "application/json"
        $this->assertTrue(
                $client->getResponse()->headers->contains(
                        'Content-Type', 'application/json'
                )
        );
// Assert that the response content contains a string
        $this->assertContains('foo', $client->getResponse()->getContent());
// ...or matches a regex
        $this->assertRegExp('/foo(bar)?/', $client->getResponse()->getContent());
// Assert that the response status code is 2xx
        $this->assertTrue($client->getResponse()->isSuccessful());
// Assert that the response status code is 404
        $this->assertTrue($client->getResponse()->isNotFound());
// Assert a specific 200 status code
        $this->assertEquals(
                200, // or Symfony\Component\HttpFoundation\Response::HTTP_OK
                $client->getResponse()->getStatusCode()
        );
// Assert that the response is a redirect to /demo/contact
        $this->assertTrue(
                $client->getResponse()->isRedirect('/demo/contact')
        );
// ...or simply check that the response is a redirect to any URL
        $this->assertTrue($client->getResponse()->isRedirect());

        //to set the Content-Type, Referer and X-Requested-With HTTP headers
        $client->request(
                'GET', '/post/hello-world', array(), array(), array(
            'CONTENT_TYPE' => 'application/json',
            'HTTP_REFERER' => '/foo/bar',
            'HTTP_X-Requested-With' => 'XMLHttpRequest',
                )
        );

        //Use the crawler to find DOM elements in the response. 
        //These elements can then be used to click on links and submit forms
        $link = $crawler->selectLink('Go elsewhere...')->link();
        $crawler = $client->click($link);
        $form = $crawler->selectButton('validate')->form();
        $crawler = $client->submit($form, array('name' => 'Fabien'));


        // Directly submit a form (but using the Crawler is easier!)
        $client->request('POST', '/submit', array('name' => 'Fabien'));
// Submit a raw JSON string in the request body
        $client->request(
                'POST', '/submit', array(), array(), array('CONTENT_TYPE' => 'application/json'), '{"name":"Fabien"}'
        );
// Form submission with a file upload
        $photo = new UploadedFile(
                '/path/to/photo.jpg', 'photo.jpg', 'image/jpeg', 123
        );
        $client->request(
                'POST', '/submit', array('name' => 'Fabien'), array('photo' => $photo)
        );
// Perform a DELETE request and pass HTTP headers
        $client->request(
                'DELETE', '/post/12', array(), array(), array('PHP_AUTH_USER' => 'username', 'PHP_AUTH_PW' => 'pa$$word')
        );

        //you can force each request to be executed in its own PHP process to 
        //avoid any sideeffects when working with several clients in the same script
        $client->insulate();

        $client->back();
        $client->forward();
        $client->reload();
// Clears all cookies and the history
        $client->restart();

        //access the client's internal objects
        $history = $client->getHistory();
        $cookieJar = $client->getCookieJar();

        // the HttpKernel request instance
        $request = $client->getRequest();
// the BrowserKit request instance
        $request = $client->getInternalRequest();
// the HttpKernel response instance
        $response = $client->getResponse();
// the BrowserKit response instance
        $response = $client->getInternalResponse();
        $crawler = $client->getCrawler();

        $container = $client->getContainer();
        $kernel = $client->getKernel();

        // enable the profiler for the very next request
        $client->enableProfiler();
        $crawler = $client->request('GET', '/profiler');
// get the profile
        $profile = $client->getProfile();

        //follow redirect
        $crawler = $client->followRedirect();
        //force to follow all redirects
        $client->followRedirects();
        //stop following redirect
        $client->followRedirects(false);

        //finds all input[type=submit] elements, selects the last one on the page, 
        //and then selects its immediate parent element
        $newCrawler = $crawler->filter('input[type=submit]')
                ->last()
                ->parents()
                ->first()
        ;
        //can be chaining
        $crawler
                ->filter('h1')
                ->reduce(function ($node, $i) {
                    if (!$node->getAttribute('class')) {
                        return false;
                    }
                })
                ->first()
        ;

        // Returns the attribute value for the first node
        $crawler->attr('class');
// Returns the node value for the first node
        $crawler->text();
// Extracts an array of attributes for all nodes
        // (_text returns the node value)
// returns an array for each element in crawler,
// each with the value and href
        $info = $crawler->extract(array('_text', 'href'));
// Executes a lambda for each node and return an array of results
        $data = $crawler->each(function ($node, $i) {
            return $node->attr('href');
        });

        //select links that contain the given text, or clickable images for which 
        //the alt attribute contains the given text
        $crawler->selectLink('Click here');

        //click the link
        $link = $crawler->selectLink('Click here')->link();
        $client->click($link);

        //select button
        $buttonCrawlerNode = $crawler->selectButton('submit');

        //select form
        $form = $buttonCrawlerNode->form();
        //can be passed values for fields
        $form = $buttonCrawlerNode->form(array(
            'name' => 'Fabien',
            'my_form[subject]' => 'Symfony rocks!',
        ));
        //simulate a specific HTTP method for the form
        $form = $buttonCrawlerNode->form(array(), 'DELETE');

        //can submit Form instances:
        $client->submit($form);
// field values can also be passed as a second argument of the submit() method:
        $client->submit($form, array(
            'name' => 'Fabien',
            'my_form[subject]' => 'Symfony rocks!',
        ));

        // Change the value of a field
        $form['name'] = 'Fabien';
        $form['my_form[subject]'] = 'Symfony rocks!';

        // Select an option or a radio
        $form['country']->select('France');
// Tick a checkbox
        $form['like_symfony']->tick();
// Upload a file
        $form['photo']->upload('/path/to/lucas.jpg');

        //different environment entirely, or override the default debug mode (true)
        $client = static::createClient(array(
                    'environment' => 'my_test_env',
                    'debug' => false,
        ));

        //passing headers
        $client = static::createClient(array(), array(
                    'HTTP_HOST' => 'en.example.com',
                    'HTTP_USER_AGENT' => 'MySuperBrowser/1.0',
        ));
        //or overwrite per request
        $client->request('GET', '/', array(), array(), array(
            'HTTP_HOST' => 'en.example.com',
            'HTTP_USER_AGENT' => 'MySuperBrowser/1.0',
        ));
    }

}
