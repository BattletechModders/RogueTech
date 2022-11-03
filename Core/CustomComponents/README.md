## About
CustomComponents(cc) - is a library that allows you to to add custom data on ComponentDef, load them from JSON definitions and use it in code. Library already have preimplemented components for json modding, but it dont contain any changed or new game items(except Exeperimental brunch for testing and demonstration). Also if you dont need preimplemented components, just mechanism to add and use additional data to json - you may take only core part(will be released as separate mod later)

## How it works
It use postfix patch to JSONSerializationUtility.RehydrateObjectFromDictionary method. After object loaded cc get control, search for "Custom" section on JSon and load custom data and store it in database 

*Note: At first I wanted to store it in the object using inheritance, but in many places the game checks the *exact* type of ComponentDef and won't work with children. [CptMoore](https://github.com/CptMoore) suggested to use external storage (a dictionary) which keeps a list of cc for each component. Testing has shown that C# dictionaries are incredebly fast, so that's how it is currently implemented.

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
