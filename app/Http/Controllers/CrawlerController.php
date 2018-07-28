<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;

class CrawlerController extends Controller
{

	public function index(){
		return view('index');
	}

	public function crawl(Request $request){

		$keyword = $request->keyword;

		$urlSearch = "http://readcomicsonline.ru/search?query=" .$keyword;

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => $urlSearch,
		));

		$resp = curl_exec($curl);

		curl_close($curl);

		$arrayResp = json_decode($resp, true);

		$listComics =  $arrayResp['suggestions'];

		return view('index', compact('listComics', 'keyword'));
	}

	public function getChapters($comic){
		$client = new Client();
		$urlRaw = 'http://readcomicsonline.ru/comic/' . $comic;
		$crawler = $client->request('GET', $urlRaw);
		$result = $crawler->filter('h5.chapter-title-rtl > a')->each(function ($node) {
			$parts = explode("/", $node->attr('href'));
			$url = end($parts);
			$comic = [
				"title" => $node->text(),
				"url" => $url,
				"rawUrl" => $node->attr('href')
			];
			return $comic;
		});
		
		return $result;
	}

	public function getAllPages($comic, $id){
		$client = new Client();
		$urlRaw = 'http://readcomicsonline.ru/comic/' . $comic .'/'. $id;		
		$crawler = $client->request('GET', $urlRaw);
		$result = $crawler->filter('#all img.img-responsive')->each(function ($node) {
			return preg_replace('/\s+/', '', $node->attr('data-src'));
		});
		
		return $result;
	}

	public function getDetailComic($comic){
		$client = new Client();
		$urlRaw = 'http://readcomicsonline.ru/comic/' . $comic;
		$crawler = $client->request('GET', $urlRaw);
		$title = trim(preg_replace('/\s+/', ' ', $crawler->filter('h2.listmanga-header')->text()));
		$image = $crawler->filter('img.img-responsive')->attr('src');
		$titleComic = $comic;
		$chapters = $this->getChapters($comic);

		return view('comic', compact('title', 'image', 'chapters', 'titleComic'));
	}

	public function readComic($comic, $id){
		
		$pages = $this->getAllPages($comic, $id);

		return view('read', compact('pages'));
	}
}
