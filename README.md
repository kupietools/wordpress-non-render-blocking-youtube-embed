# wordpress-non-render-blocking-youtube-embed
Wordpress code to create a shortcode to embed a youtube video that doesn't start loading until after the page is finished and displayed. Otherwise page display waits for all embedded videos to load. 

Put the attached PHP (probably minus the opening `<?php` tag) into your theme's functions.php file or a custom plugin file. 

This will enable you to embed YouTube video without the page load being blocked by waiting for the video to load before the page displays. Because of this, there may be delays after the user begins to interact with the page, before the video appears. This shortcode is when that is preferable to holding up the page display entirely while the videos load.

When you use YouTube's "share" feature to get a video embed code, it gives you something like this: `<iframe width="560" height="315" src="https://www.youtube.com/embed/Lp2Y2cXmxPY?si=KC_ZOMsO-N-MIgEh" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>`

What you want is the value of the `src` attribute. To embed the above video use that in the shortcode as follows:

`[ytembed url="https://www.youtube.com/embed/Lp2Y2cXmxPY?si=KC_ZOMsO-N-MIgEh"]` to embed the video as-is
`[ytembed url="https://www.youtube.com/embed/Lp2Y2cXmxPY?si=KC_ZOMsO-N-MIgEh" width="45%" float="left"]` to embed the video, make it take up 45% of the available horizontal space, and float it left, meaning other page elements such as text or other videos will wrap around its right side. 
