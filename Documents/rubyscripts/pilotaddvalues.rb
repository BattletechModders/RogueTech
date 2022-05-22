#!/usr/bin/env ruby

require "json"

changed_files = []                                   # initialize a list that will hold files we believe successfully were updated
errored_files = []                                   # initialize a list that will hold files we could not update successfully (for manual updating?)

Dir.glob('**/pilot_*.json').each do |filename|
  original_content = File.read(filename)
  puts original_content
  puts "-------"
  parsed = JSON.parse(original_content)
  puts parsed
  puts "-------"
  parsed["BaseGunnery"] = parsed["BaseGunnery"].to_i - 1
  parsed["BasePiloting"] = parsed["BasePiloting"].to_i - 1
  parsed["BaseGuts"] = parsed["BaseGuts"].to_i - 1
  parsed["BaseTactics"] = parsed["BaseTactics"].to_i - 1
  puts parsed
  puts "-------"
  File.open(filename, 'w') { |file| file.write(JSON.pretty_generate(parsed)) }
  changed_content = File.read(filename)
  puts changed_content
end

puts("Successfully Updated:")
changed_files.each do |filename|
  puts("  * #{filename}")                            # write out all the successfully updated files
end

puts("Files failed to update:")
errored_files.each do |filename|
  puts("  * #{filename}")                            # write out all the not successfully updated files
end
puts
puts "hit enter key to end program"
gets