---
layout: article
comments: true
title: "How Plugin Works"
modified:
categories: doc
excerpt: "Explanation of Easy Listings Map and how it works and how to use it."
tags: []
image:
  feature:
  teaser: how-to-teaser.png
  thumb:
date: 2015-06-05T02:50:25+04:30
---

In this post I will explain how **Easy Listings Map** works and how to use it.

###How Easy Listings Map works :
**Easy Listings Map** works by means of coordinates of **listings**, so if a **listing** has not filled coordinates field it will not shown in the map of **Easy Listings Map** in other words if you want to **listings** shown in the map you should add coordinates of them exactly.

####Why Easy Listings Map works by coordinates of listings?
Because it is a best way to showing **listings** in the map from speed view. If it uses address of **listings** to showing them in the map it will reduce speed because address needs to geocoded and geocoding listings address will reduce speed of the site and map loading.

###How to use Easy Listings Map :
When you want to adding a new **listing** you should add it's coordinates from property addess in `latitude,longitude` format as you use it in **Easy Property Listings**. For example look at the below image.

![listing coordinate]({{ site.url }}/images/how-to-teaser.png)

###What should I do if a listing doesn't shown in the **single listing page** map?
It can depends on below issues.

1. Check your listing coordinate and sure that it has exact coordinate. If it's coordinate is right it should be shown in the map if not refer to below issue.
2. Check settings of **Easy Listings Map** and sure that **Display map in single listing page** is enabled.

###What should I do if a listing doesn't shown in the **Google maps shortcode**?
It can depends on below issues.

1. Check your listing coordinate and sure that it has exact coordinate. If it's coordinate is right and it does'nt shown in the map refer to below issues.
2. Check that you choosed listing type and it's status in shortcode, because listings will be shown in the **listings map** if their listing type and status choosed and enabled in the shortcode. For more details refer to below image.

![listing type status]({{ site.url }}/images/listing-type-status.png)

![shortcode listing type status]({{ site.url }}/images/shortcodes-listing-type-status.png)

As you can see in the above image, this shortcode only loads listings with **property** and **rental** type with status **current** and **sold** and **leased**.

###Samples
* Map in the single listing page.
	* Roadmap view

	![single listing map roadmap]({{ site.url }}/images/single-roadmap.png)

	* Sattelite view

	![single listing map sattelite]({{ site.url }}/images/single-sattelite.png)

* Listings map ( Google maps shortcode )
	* Listing map that has more listings close to each other that shown inside bubble

	![bubble map]({{ site.url }}/images/bubble-map.png)

	* Listing info in the map

	![map infowindow]({{ site.url }}/images/listing-info.png)

	* Multiple listing in same coordinate that shown in separate tabs

	![multiple listing in the map]({{ site.url }}/images/multiple-listing-info-1.png)

	![multiple listing in the map]({{ site.url }}/images/multiple-listing-info-2.png)

###More features?
As you know maybe, in the **Easy Property Listings** adding coordinates is not as easy as possible, so we can add a feature to make it simple only by moving marker in the map so when you move marker in the map it will automatically produce right coordinate for it, if you want this feature please request it in the comments.

Which features you want to adding in the **Easy Listings Map** that can be used by other users and makes map of **Easy Property Listings** easy and complete?