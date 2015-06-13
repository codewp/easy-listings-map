---
layout: article
comments: true
title: "Plugin Shortcodes"
modified:
categories: doc
excerpt: "Explanation of Easy Listings Map shortcodes and how to create listings map with Easy Listings Map to showing site listings in the map."
tags: []
image:
  feature:
  teaser: shortcodes-teaser.png
  thumb:
date: 2015-06-04T16:20:35+04:30
---

In this post I will describe shortcodes of **Easy Listings Map**. You can add **Easy Listings Map** shortcodes from **Pages** and **Posts** in **Admin side of Wordpress**.

###How to create a map for showing listings :

It's good to adding **Easy Listings Map** shortcode in **pages of Wordpress** but also you can add them in **posts**.

For creating a Shortcode to showing **listings** in the map create a new page or choose existing page from **Wordpress Admin side**, there is a marker button at top of Wordpress editor like below image.

![marker button]({{ site.url }}/images/editor-marker.png)

Select marker button from editor, so it will show a form like below image.

![shortcode form]({{ site.url }}/images/shortcodes-teaser.png)

####Shortcode form items description :
* Title : This option controls title of the map, if it's lefts empty map will be shown without any title.

* Listing types that shown in the map : This option controls listings type that will shown in the map, by means of this option you can choose which type of listings should be shown in the **listings map**.

* Listing status : This option controls choosed listing types status, by means of this option you can choose which status of listings should be shown in the **listings map**. For example if you choose **property** listing type and choose current status, **listings map** will shows current properties listings.

* Number of listings in the map : This option controls number of listings that will be shown in the **listings map** if it's value is -1, **listings map** will show all of available choosed listings in other words it will not apply any limit to  available listings.

* Listings order : This option controls order of listings in **listings map** in other words you can choose new or old listings if you apply limit**( Number of listings in the map )** from above option.

* Map display types :  This option controls display types of the map. There are **( Roadmap, Sattelite, Hybrid, Terrain )** displays for the map. By selecting each of display types end user can see map in various display types that you selected from **Easy Listings Map** settings menu. Also if you enable more than one display type for the map end user can moves between map types by map controls in order to seeing map by selected type.

* Map height: This option controls map **HTML element** height. You can specify height of the map in pixels.

* Map width: This option controls map **HTML element** width. You can specify width of the map in pixels.

* Map Auto Zoom Feature: If enabled map will automatically choose best zoom level in order to showing many of listings in the map but if it is disabled you should choose your desired zoom level from below option **( Map zoom )**.

* Map zoom: This option will enable if map auto zoom feature disabled from above option **( Map Auto Zoom Feature )** so you can choose your desired zoom level of the map from 0 to 18.

* Cluster grid size: This option controls grid size of clusters in the map.

* Default latitude of the map: This option controls map default coordinate **latitude**. If there is not any listing in the map, map will choose default coordinate as center of the map.

* Default longitude of the map: This option controls map default coordinate **longitude**. If there is not any listing in the map, map will choose default coordinate as center of the map.

* HTML element id of the map: This option controls **id** attribute of the **HTML element**, if it lefts empty map will produce **id** attribute automatically based on time.