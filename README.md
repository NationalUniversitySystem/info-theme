# NUS WP Info Theme

## Overview
This WordPress theme was created so that all of the National University affiliate info websites would have a standardized codebase to work with.

When building a new info site for an affiliate, the first step is to make a **child theme** of the `info-theme` theme.

This will let you use the power of the full theme, while allowing customization where needed.

## Legend
The below numbers correspond to the [Numbered Map](Info-Theme-Numbered-Guide.jpg), explaining what content in the admin changes what on the front end. While we tried to account for as much as possible, each affiliate’s info site will ultimately have its own unique requirements that may need to be added or removed as necessary. Please do not hesitate to ask if you have any questions.


1. Sets the hero image background URL.
2. Sets the gravity form that should display on the page.
3. Sets the Quote.
4. Sets the Quotee, or who said the quote.
5. Optional, some pages have an extra line such as “Student, Class of 2020”.
6. Content for the first column block.
7. Content for the second column block.
8. This will set custom content for the callout box. This column is normally the same throughout the site, and is set on a global level via #18 in the customizer.  If not custom, leave empty.
9. Set the awards, using the Media Library. Ignore “Awards - Compatibility”, this is for backwards compatibility on existing info sites.
10. The `<h1>` of the page, the main hero tagline. Wrap the content in a `<span>` element to dictate where the text breaks on mobile resolutions. E.G: `<span>This Line Will Be</span> Separate From This Line On Mobile`.
11. The `<h2>` of the page, in the hero. The <span> rule applies here as well.
12. Student name in the hero.
13. Student title in the hero.
14. This determines what programs are to display on the form, as some forms only have specific programs available to them.This will be up to the developer, as there are a few options:
    1. ( Preferred Method ) Create custom post type of `program` with a taxonomy of `degree-type`.
        1. This will always update the dropdown field on the frontend and the choices in the admin when making changes to the CPT’s.
    2. Fill out the drop down once and save it as a “Save as new custom choice”.
        2. This will have to be manually updated each time.
15. Sets the global terms and conditions of the site.
16. Sets the default form intro text, e.g. “Please complete the form below to get started today.”
17. Sets the form that should display if no form is selected on a per-page basis.
18. Sets the default “Callout” column content.
19. Sets the global “Why Choose” column content.
