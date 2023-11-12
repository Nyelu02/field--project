import 'package:flutter/material.dart';
import 'package:green/screens/add_place_screen.dart'; // Make sure to import the correct path for AddPlaceScreen

void main() {
  runApp(MyApp());
}

class MyApp extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Green App',
      theme: ThemeData(
        primarySwatch: Colors.green,
        visualDensity: VisualDensity.adaptivePlatformDensity,
      ),
      home: AddPlaceScreen(),
    );
  }
}
