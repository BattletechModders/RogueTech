#!/usr/bin/env ruby

require "json"

Dir.glob('**/chassisdef_*.json').each do |filename|
  original_content = File.read(filename)
  puts original_content
  puts "-------"
  parsed = JSON.parse(original_content)
  puts parsed
  puts "-------"
  parsed["Description"]["Cost"] = parsed["Description"]["Cost"] * 10
  puts parsed
  puts "-------"
  File.open(filename, 'w') { |file| file.write(JSON.pretty_generate(parsed)) }
  changed_content = File.read(filename)
  puts changed_content
end

puts("Successfully Updated:")
changed_files.each { |filename| puts("  * #{filename}") }
puts("Files failed to update:")
errored_files.each { |filename| puts("  * #{filename}") }
puts
puts "hit a key to end program"
gets