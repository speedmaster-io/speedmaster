require 'mechanize'
@agent = Mechanize.new
puts @agent.get('http://127.0.0.1').content