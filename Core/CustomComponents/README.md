## About
CustomComponents(cc) - is a library that allows you to to add custom data on ComponentDef, load them from JSON definitions and use it in code. Library already have preimplemented components for json modding, but it dont contain any changed or new game items(except Exeperimental brunch for testing and demonstration). Also if you dont need preimplemented components, just mechanism to add and use additional data to json - you may take only core part(will be released as separate mod later)

## How it works
It use postfix patch to JSONSerializationUtility.RehydrateObjectFromDictionary method. After object loaded cc get control, search for "Custom" section on JSon and load custom data and store it in database 

*note: at first i want to store it in object using inheritance, but in many places game check exact type of ComponentDef and dont work with childs. [CptMoore](https://github.com/CptMoore) suggest to use external storage(Dictionary) which keep list of cc for each component Testing shows that C# Dictionary incredebly fast so it used now*

## How to use it

### Basics

Add `"Custom" : { }` attribute to Json file

Add components to it
```
{
"Custom" : {
  "Color" : { "Color" : "Red" },
  "Category" : {
     "CategoryID" : "HeatSink",
     "Tag" : "Single"
   }
}
... rest of default definition...
}
```
### For Json only modding
[[Predefined Components]]

### For Dll modding
[[Adding and handling own Components|Dll modding]]