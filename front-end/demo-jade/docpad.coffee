# DocPad Configuration File
# http://docpad.org/docs/config

docpadConfig = {
  port: 9006
  templateData:
    site:
      # The default title of our website.
      title: "demo jade"

      # The production url of our website.
      url: "http://example.com"

      # The website description (for SEO).
      description: """
        When your website appears in search results in say Google, the text here
        will be shown underneath your website's title.
        """

      # The website keywords (for SEO) separated by commas.
      keywords: """
        place, your, website, keywords, here
        """

      # The cascading stylesheets for the site.
      styles: [
        "styles/main.css"
      ]

      # The JavaScript files for the site.
      scripts: [
        "vendor/jquery/dist/jquery.min.js"
        "vendor/bootstrap-sass-official/vendor/assets/javascripts/bootstrap.js"
        "main.js"
      ]

       # Helper Functions
      # ----------------

      # Get the prepared site/document title
      # Often we would like to specify particular formatting to our page's title
      # we can apply that formatting here
      getPreparedTitle: ->
        # if we have a document title, then we should use that and suffix the site's title onto it
        if @document.title
          "#{@document.title} | #{@site.title}"
        # if our document does not have it's own title, then we should just use the site's title
        else
          @site.title

      # Get the prepared site/document description
      getPreparedDescription: ->
        # if we have a document description, then we should use that, otherwise use the site's description
        @document.description or @site.description

      # Get the prepared site/document keywords
      getPreparedKeywords: ->
        # Merge the document keywords with the site keywords
        @site.keywords.concat(@document.keywords or []).join(', ')

  # =================================
  # Watching configuration option
  #
  watchOptions:
    preferredMethods: ['watchFile','watch']
    catchupDelay: 0
  regenerateDelay: 0

  # =================================
  # Collections
  # collecions

  # =================================
  # Plugins
  plugins:
    livereload:
      enabled: true

}

# Export the DocPad Configuration
module.exports = docpadConfig
