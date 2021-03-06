# DocPad Configuration File
# http://docpad.org/docs/config

docpadConfig = {
  port: 8905
  templateData:
    site:
      # The default title of our website.
      title: "training sass"

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
        "/styles/main.css"
      ]

      # The JavaScript files for the site.
      scripts: [
        "vendor/jquery/dist/jquery.min.js"
        "vendor/bootstrap/dist/js/bootstrap.min.js"
        "main.js"

      ]

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
    # sass:
    #   compass: "true"
    #   requireLibraries: ['singularitygs']
    #   outputStyle: 'expanded'

}

# Export the DocPad Configuration
module.exports = docpadConfig
