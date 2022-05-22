#!/usr/bin/env ruby

require "json"

changed_files = []                                   # initialize a list that will hold files we believe successfully were updated
errored_files = []                                   # initialize a list that will hold files we could not update successfully (for manual updating?)

Dir.glob('**/emod_engine_*.json').each do |filename|
  original_content = File.read(filename)
  puts original_content
  puts "-------"
  parsed = JSON.parse(original_content)
  puts parsed
  puts "-------"
  parsed["Custom"]["WorkOrderCosts"]["Install"]["TechCost"] = "#{parsed['Custom']['EngineCore']['Rating']} * [[Chassis.Tonnage]]/ 2000"
  parsed["Custom"]["WorkOrderCosts"]["Install"]["CBillCost"] = "#{parsed['Custom']['EngineCore']['Rating']} * [[Chassis.Tonnage]] * [[Chassis.Tonnage]] / 10"
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